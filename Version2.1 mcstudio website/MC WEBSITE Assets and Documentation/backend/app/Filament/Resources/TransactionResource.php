<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Transaction;
use Squire\Models\Currency;
use Filament\Resources\Form;
use App\Models\PurchaseOrder;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Filament\Resources\TransactionResource\Widgets\TypeOverview;
use App\Filament\Resources\TransactionResource\Widgets\CashFlowOverview;
use Filament\Forms\Components\Fieldset;
use DB;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Accounts';

    protected static ?string $recordTitleAttribute = 'number';

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
                        ])
                        ->columnSpan(['lg' => fn (?Transaction $record) => $record === null ? 3 : 2]),
                    
    
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn (Transaction $record): ?string => $record->created_at?->diffForHumans()),
    
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn (Transaction $record): ?string => $record->updated_at?->diffForHumans()),
                        ])
                        ->columnSpan(['lg' => 1])
                        ->hidden(fn (?Transaction $record) => $record === null),
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
                Tables\Columns\TextColumn::make('payment_reference')
                    ->searchable()
                    ->getStateUsing(fn(Model $record) => strtoupper($record->payment_reference))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->getStateUsing(fn(Model $record) => ucfirst($record->type))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('currency')
                    ->getStateUsing(fn ($record): ?string => Currency::find(mb_strtolower($record->currency))?->name ?? null)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('amount')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('method')
                    ->label('Payment Method')
                    ->getStateUsing(fn(Model $record) => ucfirst($record->method))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Payment Date')
                    ->date()
                    ->toggleable(),
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
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getWidgets(): array
    {
        return [
            CashFlowOverview::class,
            TypeOverview::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
    public static function getFormSchema(?string $section = null): array
    {
        $transaction = DB::table('transactions')->whereNotNull('created_at')->latest('created_at')->first();
        if($transaction){
         $newTransaction= ($transaction->id) +1;
        }
         else{
             $newTransaction= 1;
         }
        return [
            Forms\Components\FieldSet::make('col1')
                ->label('')
                ->schema([

                    Forms\Components\TextInput::make('number')
                        ->default('TR-' . str_pad($newTransaction, 8, 0, STR_PAD_LEFT))
                        ->disabled()
                        ->required(),

                    Forms\Components\TextInput::make('payment_reference')
                        ->label('Payment Reference')
                        ->required(),
                    
                    Forms\Components\Select::make('type')
                        ->options([
                            'income' => 'Income',
                            'expense' => 'Expense'
                        ])
                        ->reactive()
                        ->required(),
            ])->columns(3),

            Forms\Components\FieldSet::make('col2')
                ->label('')
                ->schema([
                    Forms\Components\Select::make('order_id')
                        ->options(function(){
                            return Order::all()->pluck('number', 'id');
                        })
                        ->label('Order No')
                        ->visible(fn(callable $get) => $get('type') == 'income' || $get('../type') == '' )
                        ->hidden(fn(callable $get) => $get('type') == 'expense')
                        ->required(),

                    Forms\Components\Select::make('purchase_order_id')
                        ->options(function(){
                            return PurchaseOrder::all()->pluck('number', 'id');
                        })
                        ->label('Purchase Order No')
                        ->visible(fn(callable $get) => $get('type') == 'expense')
                        ->hidden(fn(callable $get) => $get('type') == 'income')
                        ->required(),

                    Forms\Components\TextInput::make('amount'),

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

                ])->columns(3),

                Forms\Components\MarkdownEditor::make('note')
                    ->label('Transaction note')
                    ->columnSpan('full'),
        ];
    }
    
}
