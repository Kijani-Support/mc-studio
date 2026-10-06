<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderReturn;
use Squire\Models\Currency;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderReturnsResource\Pages;
use App\Filament\Resources\OrderReturnsResource\RelationManagers;
use DB;

class OrderReturnsResource extends Resource
{
    protected static ?string $model = OrderReturn::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Stock Management';

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

                        Forms\Components\Section::make('Order Return items')
                            ->schema(static::getFormSchema('items')),
                    ])
                    ->columnSpan(['lg' => fn (?OrderReturn $record) => $record === null ? 3 : 2]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.number')
                    ->label('Order Number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.user.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'cancelled',
                        'warning' => 'processing',
                        'success' => fn ($state) => in_array($state, ['returned', 'accepted']),
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
                        ->with(['order', 'order.items'])
                        ->withoutGlobalScope(SoftDeletingScope::class);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderReturns::route('/'),
            'create' => Pages\CreateOrderReturns::route('/create'),
            'edit' => Pages\EditOrderReturns::route('/{record}/edit'),
            'view' => Pages\ViewOrderReturns::route('/{record}'),
        ];
    }
    
    public static function getFormSchema(?string $section = null): array
    {
        if ($section === 'items') {
            return [
                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->options(function(callable $get){
                                $orderNumber = $get('../../order_id');
                                
                                if($orderNumber){
                                    $order = Order::where('id', $orderNumber)->first();
                                    $products = $order->items->mapWithKeys( function($item){
                                        $product = Product::find($item->product_id);
                                        return [
                                            $product->id => $product->name
                                        ];
                                    });
                                    
                                    return $products->toArray();
                                }
                                return [];
                            })
                            ->label('Product')
                            ->required()
                            ->reactive()
                            ->preload()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('unit_price', Product::find($state)?->cost ?? 0))
                            ->columnSpan([
                                'md' => 5,
                            ]),

                        Forms\Components\TextInput::make('qty')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->maxValue(function(callable $get){
                                $orderNumber = $get('../../order_id');
                                
                                if($orderNumber){
                                    $order = Order::where('id', $orderNumber)->first();
                                    if($productId = $get('product_id')){
                                        $qty = $order->items->where('order_id', $order->id)->where('product_id', $productId)->first()?->qty;
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

                        Forms\Components\TextInput::make('unit_price')
                            ->label('Cost')
                            ->disabled()
                            ->numeric()
                            ->required()
                            ->columnSpan([
                                'md' => 3,
                            ]),
                    ])
                    ->defaultItems(1)
                    ->disableLabel()
                    ->columns([
                        'md' => 10,
                    ])
                    ->required(),
            ];
        }
        $orderReturn = DB::table('order_returns')->whereNotNull('created_at')->latest('created_at')->first();
       if($orderReturn){
        $neworderReturn = ($orderReturn->id) +1;
       }
        else{
            $neworderReturn = 1;
        }
        return [
            Forms\Components\TextInput::make('number')
                ->default('SR-' . str_pad($neworderReturn ? $neworderReturn : 1, 8, 0, STR_PAD_LEFT))
                ->disabled()
                ->required(),

            Forms\Components\Select::make('customer_id')
                ->searchable()
                ->required()
                ->options(function(){
                    return User::customers()->get()->pluck('name', 'id')->toArray();
                })
                ->label('Customer')
                ->preload()
                ->reactive()
                ->afterStateUpdated(
                    function ($state, callable $set){
                        $state ? $set('user_id', $state) : $set('user_id', null);
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
            
            Forms\Components\Select::make('order_id')
                ->relationship('order', 'number')
                ->searchable()
                ->options(function($state, callable $get, callable $set){
                    $customerId = $get('user_id');

                    if($customerId){
                        $orders = Order::whereHas('user', function($query) use ($customerId){
                            $query->where('id', $customerId);
                        })->get();

                        if($orders){
                            return $orders->pluck('number', 'id')->toArray();
                        }

                        return [];
                    }
                })
                ->reactive()
                ->afterStateUpdated(function($state, callable $set){
                    $set('product_id', null);
                })
                ->preload(),
            
            Forms\Components\MarkdownEditor::make('reason')
                ->label('Return Reason')
                ->required()
                ->columnSpan('full'),
        ];
    }
}
