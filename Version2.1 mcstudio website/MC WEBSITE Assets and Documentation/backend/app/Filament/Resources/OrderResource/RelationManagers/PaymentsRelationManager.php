<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Akaunting\Money\Currency;
use Filament\Resources\Table;
use Illuminate\Support\Facades\DB;
use Filament\Resources\RelationManagers\RelationManager;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $recordTitleAttribute = 'reference';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reference')
                    ->columnSpan('full')
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                    ->required(),

                Forms\Components\Select::make('currency')
                    ->options(collect(Currency::getCurrencies())->mapWithKeys(fn ($item, $key) => [$key => data_get($item, 'name')]))
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('provider')
                    ->options([
                        'mpesa' => 'Mpesa',
                        'bank'=>'Bank',
                        'cash' => 'Cash',
                    ])
                    ->required(),

                Forms\Components\Select::make('method')
                    ->options([
                        'credit_card' => 'Credit card',
                        'bank_transfer' => 'Bank transfer',
                        'pesapal' => 'Pesa Pal',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->sortable()
                    ->money(fn ($record) => $record->currency),

                Tables\Columns\TextColumn::make('provider')
                    ->formatStateUsing(fn ($state) => Str::headline($state)),

                Tables\Columns\TextColumn::make('method')
                    ->formatStateUsing(fn ($state) => Str::headline($state)),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->after(
                    function(RelationManager $livewire){
                        $order = $livewire->ownerRecord->load('payments');

                        $transaction = DB::table('transactions')->whereNotNull('created_at')->latest('created_at')->first();
                        if($transaction){
                        $newTransaction= ($transaction->id) +1;
                        }
                        else{
                            $newTransaction= 1;
                        }
                        // create a transaction
                        Transaction::create([
                            'number'  => $newTransaction,
                            'payment_reference'  => $order->number,
                            'type'    => 'income',
                            'method'  => $order->payments->first()->provider,
                            'order_id'  => $order->id,
                            'amount'  => $order->payments->first()->amount,
                            'currency'  => $order->payments->first()->currency
                        ]);
                    }
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
