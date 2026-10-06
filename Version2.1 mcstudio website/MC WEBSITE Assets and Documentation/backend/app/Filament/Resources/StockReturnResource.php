<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Product;
use App\Models\StockReturn;
use Squire\Models\Currency;
use Filament\Resources\Form;
use App\Models\PurchaseOrder;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use App\Forms\Components\AddressForm;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StockReturnResource\Pages;
use DB;

class StockReturnResource extends Resource
{
    protected static ?string $model = StockReturn::class;

    protected static ?string $slug = 'stockreturns';

    protected static ?string $recordTitleAttribute = 'number';

    protected static ?string $navigationGroup = 'Stock Management';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema(static::getFormSchema())
                            ->columns(2),

                        Forms\Components\Section::make('Stock Return items')
                            ->schema(static::getFormSchema('items')),
                    ])
                    ->columnSpan(['lg' => fn (?StockReturn $record) => $record === null ? 3 : 2]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (StockReturn $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (StockReturn $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?StockReturn $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'cancelled',
                        'warning' => 'processing',
                        'success' => fn ($state) => in_array($state, ['returned', 'accepted']),
                    ]),
                Tables\Columns\TextColumn::make('currency')
                    ->getStateUsing(fn ($record): ?string => Currency::find($record->currency)?->name ?? null)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->getStateUsing(function (Model $record){
                        $total = $record->items->sum(function($item): float {
                            return (float) ($item->cost_price * $item->qty);
                        });
                        return money($total, $record->currency, true);
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Stock Return Date')
                    ->date()
                    ->toggleable(),
            ])
            ->filters([

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->placeholder(fn ($state): string => now(-5)->format('M d, Y')),
                        Forms\Components\DatePicker::make('created_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Returned from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Returned until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function () {
                        // Notification::make()
                        //     ->title('Now, now, don\'t be cheeky, leave some records for others to play with!')
                        //     ->warning()
                        //     ->send();
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            //StockReturnStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockReturns::route('/'),
            'create' => Pages\CreateStockReturn::route('/create'),
            'edit' => Pages\EditStockReturn::route('/{record}/edit'),
          //  'view' => Pages\ViewStockReturn::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['number', 'user.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var StockReturn $record */

        return [
            'User' => optional($record->user)->name,
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user', 'items']);
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }

    public static function getFormSchema(?string $section = null): array
    {
        if ($section === 'items') {
            return [
                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Product')
                            ->options(function(callable $get){
                                $purchase_order_id = $get('../../purchase_order_id');

                                if($purchase_order_id){
                                    $purchase_order = PurchaseOrder::where('id', $purchase_order_id)->first();
                                    $products = $purchase_order->items->mapWithKeys( function($item){
                                        $product = Product::find($item->product_id);
                                        return [
                                            $product->id => $product->name
                                        ];
                                    });
                                    return $products->toArray();
                                }
                                return [];
                            })
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function($state, callable $set) {
                                 $set('cost_price', Product::find($state)?->cost ?? 0);
                                 $set('qty', 1);
                            })
                            ->columnSpan([
                                'md' => 5,
                            ]),

                        Forms\Components\TextInput::make('qty')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->maxValue(function(callable $get){
                                $purchase_order_id = $get('../../purchase_order_id');
                                
                                if($purchase_order_id){
                                    $purchase_order = PurchaseOrder::where('id', $purchase_order_id)->first();
                                    if($productId = $get('product_id')){
                                        $qty = $purchase_order->items->where('purchase_order_id', $purchase_order->id)->where('product_id', $productId)->first()?->qty;
                                        return $qty;
                                    }
                                    return 1;
                                }
                                return 1;
                            })
                            ->columnSpan([
                                'md' => 2,
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('cost_price')
                            ->label('Cost')
                            ->disabled()
                            ->numeric()
                            ->required()
                            ->columnSpan([
                                'md' => 3,
                            ]),
                    ])
                    ->orderable()
                    ->defaultItems(1)
                    ->disableLabel()
                    ->columns([
                        'md' => 10,
                    ])
                    ->required(),
            ];
        }
        $stockReturn = DB::table('stock_returns')->whereNotNull('created_at')->latest('created_at')->first();
        if($stockReturn){
         $newstockReturn = ($stockReturn->id) +1;
        }
         else{
             $newstockReturn= 1;
         }

        return [
            Forms\Components\TextInput::make('number')
                ->default('SR-' . str_pad($newstockReturn, 8, 0, STR_PAD_LEFT))
                ->disabled()
                ->required(),

            Forms\Components\Select::make('user_id')
                ->searchable()
                ->required()
                ->options(function(){
                    return User::suppliers()->get()->pluck('name', 'id')->toArray();
                })
                ->label('Supplier')
                ->preload()
                ->reactive()
                ->disabled(fn($context):bool => $context !== 'create' )
                ->afterStateUpdated(
                    function ($state, callable $set){
                        // $state ? $set('user_id', $state) : $set('user_id', null);
                        $set('order_id', null);
                    } 
                ),

            Forms\Components\Select::make('status')
                ->options([
                    'new' => 'New',
                    'processing' => 'Processing',
                    'returned' => 'Returned',
                    'cancelled' => 'Cancelled',
                ])
                ->default('new')
                ->required(),
            
            Forms\Components\Select::make('purchase_order_id')
                ->relationship('purchase_order', 'number')
                ->searchable()
                ->options(function($state, callable $get, callable $set){
                    $supplierId = $get('user_id');

                    if($supplierId){
                        $Po = PurchaseOrder::whereHas('user', function($query) use ($supplierId){
                            $query->where('id', $supplierId);
                        })->get()->pluck('number', 'id')->toArray();

                        return $Po;
                    }
                })
                ->reactive()
                ->disabled(fn($context):bool => $context !== 'create')
                ->afterStateUpdated(fn (callable $set) => $set('product_id', null))
                ->preload(),
            
            Forms\Components\MarkdownEditor::make('notes')
                ->label('Reason')
                ->required()
                ->columnSpan('full'),
        ];
    }
}
