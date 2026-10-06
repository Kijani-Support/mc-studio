<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountDetailsResource\Pages;
use App\Filament\Resources\AccountDetailsResource\RelationManagers;
use App\Models\AccountDetails;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class AccountDetailsResource extends Resource
{
    protected static ?string $model = AccountDetails::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Business Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
            ->schema([
                TextInput::make('bank_details')
                    ->maxLength(255),
                TextInput::make('mpesa_details')
                    ->maxLength(255),
                TextInput::make('additional_notes')
                    ->maxLength(255),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bank_details')->sortable(),
                TextColumn::make('mpesa_details')->sortable(),
                TextColumn::make('additional_notes')->sortable(),
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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccountDetails::route('/'),
            'create' => Pages\CreateAccountDetails::route('/create'),
            'edit' => Pages\EditAccountDetails::route('/{record}/edit'),
        ];
    }    
}
