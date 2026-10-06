<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Squire\Models\Currency;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Accounts';

    protected static ?string $recordTitleAttribute = 'number';

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
                        ])
                        ->columnSpan(['lg' => fn (?Payment $record) => $record === null ? 3 : 2]),
                    
    
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn (Payment $record): ?string => $record->created_at?->diffForHumans()),
    
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn (Payment $record): ?string => $record->updated_at?->diffForHumans()),
                        ])
                        ->columnSpan(['lg' => 1])
                        ->hidden(fn (?Payment $record) => $record === null),
                ])
                ->columns(3);
    }


    //map for mpesa

    // {
    //     "TransactionType": "Pay Bill" : method,
    //     "TransID": "NAF81H7Y72" : reference,
    //     "TransTime": "20190115234802" : created_at,
    //     "TransAmount": "100.00" : amount,
    //     "BusinessShortCode": "601380"//validate against this,
    //     "BillRefNumber": "Testing" : order_id,
    //     "InvoiceNumber": ""//,
    //     "OrgAccountBalance": "900.00" //,
    //     "ThirdPartyTransID": "" //,
    //     "MSISDN": "254708374149" : phone ,
    //     "FirstName": "John" : name,
    //     "MiddleName": "J." //,
    //     "LastName": "Doe" //
    // }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('reference')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('phone')
                ->searchable()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('currency')
                ->getStateUsing(fn ($record): ?string => Currency::find($record->currency)?->name ?? null)
                ->searchable()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('amount')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('provider')
                ->label('Payment Method')
                ->searchable()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Payment Date')
                ->date()
                ->toggleable(),
            
        ])
         ->filters([
                //Tables\Filters\TrashedFilter::make(),

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
                ])
                ->bulkActions([
                    Tables\Actions\DeleteBulkAction::make(),
                ]);
    }

    public static function getFormSchema(?string $section = null): array
    {
        return [
            Forms\Components\TextInput::make('number')
                ->default('PY-' . random_int(100000, 999999))
                ->disabled()
                ->required(),
            Forms\Components\TextInput::make('order_id')
                ->label('Payment Reference')
                ->required(),

            Forms\Components\TextInput::make('reference')
                ->label('Order No')
                ->required(),

            Forms\Components\Select::make('provider')
                ->options([
                    'mpesa' => 'Mpesa',
                    'bank' => 'Bank',
                    'cash' => 'Cash',
                ])
                ->required(),
            Forms\Components\Select::make('method')
                ->options([
                    'mpesa' => 'Mpesa',
                    'bank' => 'Bank',
                    'cash' => 'Cash',
                ])
                ->required(),

            Forms\Components\Select::make('currency')
                ->searchable()
                ->getSearchResultsUsing(fn (string $query) => Currency::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                ->getOptionLabelUsing(fn ($value): ?string => Currency::find($value)?->getAttribute('name'))
                //->default('kes')
                ->required(),

            Forms\Components\TextInput::make('amount'),

            Forms\Components\TextInput::make('phone'),

            Forms\Components\TextInput::make('name'),

        ];
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }    
}
