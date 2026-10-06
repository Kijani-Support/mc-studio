<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailSettingResource\Pages;
use App\Filament\Resources\EmailSettingResource\RelationManagers;
use App\Models\EmailSetting;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmailSettingResource extends Resource
{
    protected static ?string $model = EmailSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    protected static ?string $navigationGroup = 'Business Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Card::make()
            ->schema([
                Forms\Components\TextInput::make('host')
                    ->required()
                    ->unique()
                    ->hint('smtp.gmail.com')
                    ->hintColor('primary')
                    ->maxLength(255),
                Forms\Components\TextInput::make('port')
                    ->required()
                    ->unique()
                    ->hint('465')
                    ->hintColor('primary')
                    ->maxLength(20),
                Forms\Components\Select::make('auth')
                    ->label('Authentication')
                    ->hintColor('primary')
                    ->hint('True')
                    ->options([
                        'true' => 'True',
                        'false' => 'False'
                    ])
                    ->required(),
                Forms\Components\Select::make('authtype')
                    ->label('Authentication Type')
                    ->hintColor('primary')
                    ->hint('SSL')
                    ->options([
                        'none' => 'None',
                        'tls' => 'TLS',
                        'ssl' => 'SSL'
                    ])
                    ->required(),
                Forms\Components\TextInput::make('sender')
                    ->label('Email from')
                    ->required()
                    ->hint('hello@kijani.co')
                    ->hintColor('primary')
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('from_name')
                    ->label('Email from name')
                    ->required()
                    ->hint('Kijani')
                    ->hintColor('primary')
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email-address')
                    ->required()
                    ->hint('hello@kijani.co')
                    ->hintColor('primary')
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->hint('Your Password')
                    ->hintColor('primary')
                    ->required()
                    ->maxLength(255),
            ])
          ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('host')
                    ->sortable(),
                Tables\Columns\TextColumn::make('port')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email-address')
                    ->sortable(),
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
            'index' => Pages\ListEmailSettings::route('/'),
            'create' => Pages\CreateEmailSetting::route('/create'),
            'edit' => Pages\EditEmailSetting::route('/{record}/edit'),
        ];
    }    
}
