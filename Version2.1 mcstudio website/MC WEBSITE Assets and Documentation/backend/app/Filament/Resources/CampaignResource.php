<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Product;
use App\Models\Campaign;
use Squire\Models\Currency;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use App\Forms\Components\AddressForm;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CampaignResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CampaignResource\RelationManagers;
use Sgcomptech\FilamentTicketing\Tables\Actions\TicketAction;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $slug = 'campaigns';

    protected static ?string $recordTitleAttribute = 'number';

    protected static ?string $navigationGroup = 'CRM';

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema(static::getFormSchema())
                            ->columns(3),

                        Forms\Components\Section::make('Campaign items')
                            ->schema(static::getFormSchema('items')),
                    ])
                    ->columnSpan(['lg' => fn (?Campaign $record) => $record === null ? 3 : 2]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Campaign $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Campaign $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Campaign $record) => $record === null),
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
                Tables\Columns\TextColumn::make('customer')
                    ->getStateUsing(function(Model $record){
                        if (is_null($record->customer_id)) {
                            return "[ Group ] ".$record->customergroup->name;
                        }
                        return $record->customer->name;
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'info'    => 'new',
                        'danger'  => 'cancelled',
                        'warning' => 'ended',
                        'success' => fn ($state) => in_array($state, ['ongoing']),
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Campaign Date')
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
           //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return auth()->user()->canany('create campaigns', 'delete campaigns')
    //     ? parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class)
    //     : parent::getEloquentQuery()->authUser()->withoutGlobalScope(SoftDeletingScope::class);
    // }

    public static function getGloballySearchableAttributes(): array
    {
        return ['number'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Campaign $record */

        return [
            'User' => optional($record->user)->name,
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['items']);
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
                    ->defaultItems(1)
                    ->disableLabel()
                    ->columns([
                        'md' => 10,
                    ])
                    ->required(),
            ];
        }

        return [
            Forms\Components\TextInput::make('number')
                ->default('CAM-' . random_int(100000, 999999))
                ->disabled()
                ->required(),

            Forms\Components\Radio::make('customer_type')
                ->label('Select a single customer or a customer group')
                ->reactive()
                ->options([
                    'single' => 'Single Customer',
                    'group'  => 'Customer Group'
                ])
                ->default('single')
                ->afterStateUpdated(
                    fn ($state, callable $set) => $state ? $set('customer_type', $state) : $set('customer_type', 'single')
                )
                ->visibleOn('create'),

            Forms\Components\Select::make('customer_id')
                ->options(User::query()->customers()->pluck('name', 'id'))
                ->label('Customer')
                ->searchable()
                ->preload()
                ->required()
                ->hidden(
                    fn ($context, Closure $get, ?Model $record): bool => ($get('customer_type') == 'group' && $context == 'create') || ( $context == 'edit' && is_null($record->customer_id) )
                )
                ->disabledOn('edit'),
            
            Forms\Components\Select::make('customer_group_id')
                ->relationship('customergroup', 'name')
                ->label('Customer Group')
                ->searchable()
                ->preload()
                ->required()
                ->hidden(
                    fn ($context, Closure $get, ?Model $record): bool => ($get('customer_type') == 'single' && $context == 'create') || ( $context == 'edit' && is_null($record->customer_group_id) )
                )
                ->disabledOn('edit'),

            Forms\Components\Select::make('status')
                ->options([
                    'new' => 'New',
                    'ongoing' => 'Ongoing',
                    'ended' => 'Ended',
                    'cancelled' => 'Cancelled',
                ])
                ->default('new')
                ->required(),

            Forms\Components\MarkdownEditor::make('notes')
                ->columnSpan('full'),
        ];
    }
}