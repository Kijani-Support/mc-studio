<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessSettingsResource\Pages;
use App\Filament\Resources\BusinessSettingsResource\RelationManagers;
use App\Models\BusinessSettings;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class BusinessSettingsResource extends Resource
{
    protected static ?string $model = BusinessSettings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Business Management';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Business Settings')
                    ->tabs([
                        Tabs\Tab::make('Business owner Details')
                            ->schema([
                                Card::make()
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('email')
                                            ->email()
                                            ->unique(ignoreRecord: true)
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('phone')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('address')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('country')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('city')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('pobox')
                                            ->label('P.O. Box')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\Section::make('Business Logo')
                                            ->schema([
                                                SpatieMediaLibraryFileUpload::make('media')
                                                    ->collection('company-logo')
                                                    ->multiple()
                                                    ->maxFiles(1)
                                                    ->disableLabel(),
                                            ])
                                            ->collapsible(),
                                    ])
                            ]),

                        Tabs\Tab::make('Business Settings')
                            ->schema([
                                Card::make()
                                    ->schema([
                                        TextInput::make('tax_amount')
                                            ->numeric()
                                            ->required()
                                            ->maxLength(255)
                                            ->helperText('Please enter the percentage figure that is to be applied. eg. if 25% enter 25'),
                                    ])
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable(),
                TextColumn::make('email')->sortable(),
                TextColumn::make('phone')->sortable(),
                TextColumn::make('address')->sortable(),
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
            'index' => Pages\ListBusinessSettings::route('/'),
            'create' => Pages\CreateBusinessSettings::route('/create'),
            'edit' => Pages\EditBusinessSettings::route('/{record}/edit'),
        ];
    }    
}
