<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\Lead;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = null;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')->required(),
                TextInput::make('last_name')->required(),
                TextInput::make('email')->email()->required(),
                TextInput::make('phone')->required(),
                Textarea::make('address'),
                TextInput::make('education')->required(),
                TextInput::make('experience')->required(),
                TextInput::make('current_role'),
                TextInput::make('company'),
                Forms\Components\CheckboxList::make('languages')
                    ->options([
                        'python' => 'Python',
                        'java' => 'Java',
                        'javascript' => 'JavaScript',
                        'nodejs' => 'Node.js',
                        'csharp' => 'C#',
                        'other' => 'Other',
                    ]),
                Forms\Components\CheckboxList::make('cloud_platforms')
                    ->options([
                        'ibm-cloud' => 'IBM Cloud',
                        'aws' => 'AWS',
                        'azure' => 'Microsoft Azure',
                        'gcp' => 'Google Cloud',
                        'none' => 'No Cloud Experience',
                    ]),
                TextInput::make('ai_experience')->required(),
                TextInput::make('availability')->required(),
                Textarea::make('motivation')->required(),
                TextInput::make('specialization')->required(),
                Textarea::make('additional_info'),
                TextInput::make('laptop_access')->required(),
                TextInput::make('internet_quality'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')->searchable(),
                TextColumn::make('last_name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('education'),
                TextColumn::make('experience'),
                TextColumn::make('ai_experience'),
                TextColumn::make('specialization'),
                TextColumn::make('created_at')->dateTime(),
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
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }    
}
