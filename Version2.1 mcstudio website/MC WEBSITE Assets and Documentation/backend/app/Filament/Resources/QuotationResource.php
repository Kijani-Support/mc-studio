<?php

namespace App\Filament\Resources;

use App\Filament\Tables\Actions\TicketAction;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Product;
use App\Models\Quotation;
use Squire\Models\Currency;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use App\Forms\Components\AddressForm;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\QuotationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuotationResource\Widgets\QuotationStats;
use Illuminate\Support\Facades\DB;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $slug = 'quotations';

    protected static ?string $recordTitleAttribute = 'number';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema(static::getFormSchema())
                            ->columns(2),

                        Forms\Components\Section::make('Quotation items')
                            ->schema(static::getFormSchema('items')),
                    ])
                    ->columnSpan(['lg' => fn (?Quotation $record) => $record === null ? 3 : 2]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Quotation $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Quotation $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Quotation $record) => $record === null),
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
                    ->label('Customer')
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
                        return money((float) $record->total_price, $record->currency, true);
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Quotation Date')
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
                            $indicators['created_from'] = 'Quotation from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Quotation until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label( fn(): string => auth()->user()->can('create quotations') ? 'Edit' : 'View')
                    ->icon( fn(): string => auth()->user()->can('create quotations') ? 'heroicon-s-pencil' : 'heroicon-o-eye'),
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
            QuotationStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
            'view' => Pages\ViewQuotation::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->can(['create quotations', 'delete quotations'])
        ? parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class)
        : parent::getEloquentQuery()->authUser()->withoutGlobalScope(SoftDeletingScope::class);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['number', 'user.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Quotation $record */

        return [
            'User' => optional($record->user)->name,
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return auth()->user()->can(['create quotations', 'delete quotations'])
        ? parent::getGlobalSearchEloquentQuery()->with(['user', 'items'])
        : parent::getGlobalSearchEloquentQuery()->authUser()->with(['user', 'items']);
    }

    protected static function getNavigationBadge(): ?string
    {
        return auth()->user()->can(['create quotations', 'delete quotations'])
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
        $quotation = DB::table('quotations')->whereNotNull('created_at')->latest('created_at')->first();
        if($quotation){
         $newquotation = ($quotation->id) +1;
        }
         else{
             $newquotation= 1;
         }

        return [
            Forms\Components\TextInput::make('number')
                ->default('QO-' . str_pad($newquotation, 8, 0, STR_PAD_LEFT))
                ->disabled()
                ->required(),

            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->label('Customer')
                ->visible(fn(): bool => auth()->user()->cannot('create quotations'))
                ->options( function(){
                    return auth()->user()->pluck('name', 'id');
                }),

            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->label('Customer')
                ->required()
                ->options(function () {
                    return User::customers()->get()->pluck('name', 'id');
                })
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->unique(),

                    Forms\Components\TextInput::make('phone'),
                ])
                ->preload()
                ->visible(fn(): bool => auth()->user()->can('create quotations'))
                ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                    return $action
                        ->modalHeading('Create customer')
                        ->modalButton('Create customer')
                        ->modalWidth('lg');
                }),

            Forms\Components\Select::make('status')
                ->options([
                    'new' => 'New',
                    'processing' => 'Processing',
                    'converted' => 'Converted',
                    'cancelled' => 'Cancelled',
                ])
                ->default('new')
                ->required()
                ->disabled(fn(?Model $record): bool => $record && $record->status === 'converted'),

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
