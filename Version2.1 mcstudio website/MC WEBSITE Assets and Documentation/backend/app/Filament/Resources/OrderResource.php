<?php

namespace App\Filament\Resources;

use App\Filament\Tables\Actions\TicketAction;
use DB;
use Closure;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Enums\OrderStatus;
use Squire\Models\Country;
use Illuminate\Support\Str;
use Squire\Models\Currency;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use App\Forms\Components\AddressForm;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $slug = 'orders';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $recordTitleAttribute = 'number';

    protected static ?string $navigationGroup = 'Sales';

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

                        Forms\Components\Section::make('Order items')
                            ->schema(static::getFormSchema('items')),
                    ])
                    ->columnSpan(['lg' => fn (?Order $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Order $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Order $record): ?string => $record->updated_at?->diffForHumans()),


                        Forms\Components\Placeholder::make('order_tax')
                            ->label('Order Tax')
                            ->content(fn (Order $record) => money($record->order_tax, $record->currency, true))
                            ->hidden(fn (?Order $record) => $record === null),

                        Forms\Components\Placeholder::make('order_net_total')
                            ->label('Order Items Total')
                            ->content(fn (Order $record) => money($record->total_price, $record->currency, true))
                            ->hidden(fn (?Order $record) => $record === null),

                        Forms\Components\Placeholder::make('order_gross_total')
                            ->label('Order Total')
                            ->content(fn (Order $record) => money($record->gross_total, $record->currency, true))
                            ->hidden(fn (?Order $record) => $record === null),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Order $record) => $record === null),
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
                        'success' => fn ($state) => in_array($state, ['delivered', 'shipped']),
                    ]),
                Tables\Columns\TextColumn::make('currency')
                    ->getStateUsing(fn ($record): ?string => Currency::find($record->currency)?->name ?? null)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->getStateUsing(function (Model $record){
                        $total = $record->gross_total;
                        return money($total, $record->currency, true);
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipping_price')
                    ->label('Shipping cost')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order Date')
                    ->date()
                    ->toggleable(),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
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
                            $indicators['created_from'] = 'Order from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Order until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->can(['create orders', 'delete orders'])
        ? parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class)
        : parent::getEloquentQuery()->authUser()->withoutGlobalScope(SoftDeletingScope::class);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['number', 'user.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Order $record */

        return [
            'User' => optional($record->user)->name,
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return auth()->user()->can(['create orders', 'delete orders'])
        ? parent::getGlobalSearchEloquentQuery()->with(['user', 'items'])
        : parent::getGlobalSearchEloquentQuery()->authUser()->with(['user', 'items']);
    }

    protected static function getNavigationBadge(): ?string
    {
        return auth()->user()->can(['create orders', 'delete orders'])
        ? static::$model::where('status', 'new')->count()
        : static::$model::where('status', 'new')->authUser()->count();
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
                            ->afterStateUpdated(fn ($state, callable $set) => $set('unit_price', Product::find($state)?->price ?? 0))
                            ->columnSpan([
                                'md' => 5,
                            ]),

                        Forms\Components\TextInput::make('qty')
                            ->numeric()
                            ->default(1)
                            ->columnSpan([
                                'md' => 2,
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('unit_price')
                            ->label('Unit Price')
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
        $order = DB::table('orders')->whereNotNull('created_at')->latest('created_at')->first();
        if($order){
         $neworderno = ($order->id) +1;
        }
         else{
             $neworderno = 1;
         }
        return [
            Forms\Components\TextInput::make('number')
                ->default('OR-'. str_pad($neworderno, 8, 0, STR_PAD_LEFT))
                ->disabled()
                ->required(),

            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->preload()
                ->required()
                ->searchable()
                ->disabled(function($context){ return $context == 'edit'; })
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->unique(),

                    Forms\Components\TextInput::make('phone'),
                ])
                ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                    return $action
                        ->modalHeading('Create customer')
                        ->modalButton('Create customer')
                        ->modalWidth('lg');
                }),

            Forms\Components\Select::make('status')
                ->options(OrderStatus::class)
                ->default('new')
                ->required(),

            Forms\Components\Select::make('currency')
                ->searchable()
                ->getSearchResultsUsing(fn (string $query) => Currency::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                ->getOptionLabelUsing(fn ($value): ?string => Currency::find($value)?->getAttribute('name'))
                //->default('kes')
                ->required(),

            Fieldset::make('Order Address')
                ->relationship('address')
                ->schema([
                    Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('country')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $query) => Country::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                            ->getOptionLabelUsing(fn ($value): ?string => Country::find($value)?->getAttribute('name')),
                        Forms\Components\TextInput::make('street')
                            ->label('Street address'),
                    ]),

                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('city'),
                        Forms\Components\TextInput::make('state')
                            ->label('State / Province'),
                        Forms\Components\TextInput::make('zip')
                            ->label('Zip / Postal code'),
                    ]),
                ]),
            Forms\Components\Select::make('shipping_method')
                ->searchable()
                ->preload()
                ->label('Shipping area')
                ->options(Shipping::query()->pluck('shipping_area', 'id'))
                ->getSearchResultsUsing(fn (string $query) => Shipping::where('shipping_area', 'like', "%{$query}%")->pluck('shipping_area','shipping_cost'))
                ->getOptionLabelUsing(fn ($value): ?string => Shipping::find($value)?->getAttribute('shipping_area'))
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set) => $state ? $set('shipping_price', Shipping::find($state)?->shipping_cost) : "0.00")
                ->required(),
            Forms\Components\TextInput::make('shipping_price')
                ->disabled(),
            Forms\Components\MarkdownEditor::make('notes')
                ->columnSpan('full'),
        ];
    }
}
