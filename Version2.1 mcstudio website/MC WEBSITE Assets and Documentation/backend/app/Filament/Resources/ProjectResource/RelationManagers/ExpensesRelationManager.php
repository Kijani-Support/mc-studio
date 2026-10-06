<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Squire\Models\Currency;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\Component;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ExpensesRelationManager extends RelationManager
{
    protected static string $relationship = 'expenses';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('currency')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $query) => Currency::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                    ->getOptionLabelUsing(fn ($value): ?string => Currency::find($value)?->getAttribute('name'))
                    //->default('kes')
                    ->required(),
                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\TextInput::make('unit_price')
                            ->label('Unit Price')
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function($state, callable $get, callable $set){
                                $unit_price = $state;
                                $qty = $get('qty') ?? 0;
                                $total = ($unit_price * $qty);
                                
                                $set('total', $total);
                            }),
                        Forms\Components\TextInput::make('qty')
                            ->numeric()
                            ->label('Quantity')
                            ->minValue(1)
                            ->maxValue(100)
                            ->reactive()
                            ->afterStateUpdated(function($state, callable $get, callable $set){
                                $qty = $state;
                                $unit_price = $get('unit_price') ?? 0;
                                $total = ($unit_price * $qty);
                                
                                $set('total', $total);
                            }),
                        Forms\Components\Section::make('Receipt(Max 2 files)')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->collection('expense-receipts')
                                    ->multiple()
                                    ->maxFiles(2)
                                    ->disableLabel(),
                            ])
                            ->collapsible(),
                        Forms\Components\TextInput::make('total')
                            ->disabled(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('currency')
                    ->getStateUsing(fn ($record): ?string => Currency::find($record->currency)?->name ?? null),
                Tables\Columns\TextColumn::make('unit_price'),
                Tables\Columns\TextColumn::make('qty')->label('Quantities'),
                Tables\Columns\TextColumn::make('total'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->after(function(RelationManager $livewire){
                    $livewire->emit('refresh');
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(function(RelationManager $livewire){
                    $livewire->emit('refresh');
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
