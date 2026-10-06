<?php

namespace App\Filament\Resources;

use App\Filament\Tables\Actions\TicketAction;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Product;
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
use App\Filament\Resources\PurchaseOrderResource\Pages;;
use App\Filament\Resources\PurchaseOrderResource\Widgets\PurchaseOrderStats;
use DB;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $slug = 'PurchaseOrders';

    protected static ?string $recordTitleAttribute = 'number';

    protected static ?string $navigationGroup = 'Stock Management';

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema(static::getFormSchema())
                            ->columns(2),

                        Forms\Components\Section::make('Purchase Order items')
                            ->schema(static::getFormSchema('items')),
                    ])
                    ->columnSpan(['lg' => fn (?PurchaseOrder $record) => $record === null ? 3 : 2]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (PurchaseOrder $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (PurchaseOrder $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?PurchaseOrder $record) => $record === null),
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
                    ->label('Supplier')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'cancelled',
                        'warning' => 'processing',
                        'success' => fn ($state) => in_array($state, ['delivered', 'shipped']),
                    ]),
                Tables\Columns\TextColumn::make('currency')
                    ->getStateUsing(fn ($record): ?string => Currency::find($record->currency)?->name ?? null)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->searchable()
                    ->getStateUsing(function (Model $record){
                        return money((float)$record->total_price, $record->currency, true);
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('PurchaseOrder Date')
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
                            $indicators['created_from'] = 'PurchaseOrder from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'PurchaseOrder until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn(): bool => auth()->user()->cannot('create purchase orders'))
                    ->color('success'),
                Tables\Actions\EditAction::make()
                    ->visible(fn(): bool => auth()->user()->can('create purchase orders')),
                TicketAction::make('ticket'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function () {
                        Notification::make()
                            ->title('Now, now, don\'t be cheeky, leave some records for others to play with!')
                            ->warning()
                            ->send();
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
            PurchaseOrderStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
            'view' => Pages\ViewPurchaseOrder::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->can(['create purchase orders', 'delete purchase orders'])
        ? parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class)
        : parent::getEloquentQuery()->authUser()->withoutGlobalScope(SoftDeletingScope::class);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['number', 'user.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var PurchaseOrder $record */

        return [
            'User' => optional($record->user)->name,
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return auth()->user()->can(['create purchase orders', 'delete purchase orders'])
        ? parent::getGlobalSearchEloquentQuery()->with(['user', 'items'])
        : parent::getGlobalSearchEloquentQuery()->authUser()->with(['user', 'items']);
    }

    protected static function getNavigationBadge(): ?string
    {
        return auth()->user()->can(['create purchase orders', 'delete purchase orders'])
        ? static::$model::count()
        : static::$model::authUser()->count();
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
                            ->options(Product::query()->pluck('name', 'id'))
                            ->required()
                            ->reactive()
                            ->disabled(fn(string $context): bool => auth()->user()->cannot('create purchase orders') || $context === 'edit')
                            ->afterStateUpdated(fn ($state, callable $set) => $set('cost_price', Product::find($state)?->cost ?? 0))
                            ->columnSpan([
                                'md' => 5,
                            ]),

                        Forms\Components\TextInput::make('qty')
                            ->numeric()
                            ->default(1)
                            ->columnSpan([
                                'md' => 2,
                            ])
                            ->disabled(fn(): bool => auth()->user()->cannot('create purchase orders'))
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
                    ->disableItemCreation(fn(string $context): bool => $context === 'edit')
                    ->disableItemDeletion(fn(string $context): bool => $context === 'edit')
                    ->columns([
                        'md' => 10,
                    ])
                    ->required(),
            ];
        }
        $purchase_orders = DB::table('purchase_orders')->whereNotNull('created_at')->latest('created_at')->first();
        if($purchase_orders){
         $newPurchase_orders = ($purchase_orders->id) +1;
        }
         else{
             $newPurchase_orders = 1;
         }

        return [
            Forms\Components\TextInput::make('number')
                ->default('PO-' . str_pad($newPurchase_orders, 8, 0, STR_PAD_LEFT))
                ->disabled()
                ->required(),

            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->label('Supplier')
                ->required()
                ->options(function () {
                    return User::suppliers()->get()->pluck('name', 'id');
                })
                ->disabled(fn(string $context):bool => $context === 'edit')
                ->preload()
                ->createOptionForm(function(string $context){
                    if($context === 'create'){
                        return [
                            Forms\Components\TextInput::make('name')
                                ->required(),

                            Forms\Components\TextInput::make('email')
                                ->required()
                                ->email()
                                ->unique(),

                            Forms\Components\TextInput::make('phone'),
                        ];
                    }
                })
                ->createOptionAction(function (Forms\Components\Actions\Action $action, string $context) {
                    if($context === 'create'){
                        return $action
                        ->modalHeading('Create supplier')
                        ->modalButton('Create supplier')
                        ->modalWidth('lg');
                    }
                }),

            Forms\Components\Select::make('status')
                ->options([
                    'new' => 'New',
                    'processing' => 'Processing',
                    'fulfilled' => 'Fulfilled',
                    'cancelled' => 'Cancelled',
                ])
                ->disabled(fn(): bool => auth()->user()->cannot('create purchase orders'))
                ->default('new')
                ->required(),

            Forms\Components\Select::make('currency')
                ->searchable()
                ->getSearchResultsUsing(fn (string $query) => Currency::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                ->getOptionLabelUsing(fn ($value): ?string => Currency::find($value)?->getAttribute('name'))
                ->required(),

            Forms\Components\MarkdownEditor::make('notes')
                ->columnSpan('full'),
        ];
    }
}

