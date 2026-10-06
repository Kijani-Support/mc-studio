<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Personal Information
                Forms\Components\TextInput::make('firstName')->required(),
                Forms\Components\TextInput::make('lastName')->required(),
                Forms\Components\DatePicker::make('dateOfBirth')->required(),
                Forms\Components\Select::make('gender')->options([
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other',
                ])->required(),
                Forms\Components\TextInput::make('nationalId')->required(),
                Forms\Components\TextInput::make('phoneNumber')->required(),
                Forms\Components\TextInput::make('email'),
                // Address Information
                Forms\Components\Select::make('district')->options([
                    'kampala' => 'Kampala',
                    'wakiso' => 'Wakiso',
                    'mukono' => 'Mukono',
                    'jinja' => 'Jinja',
                    'mbarara' => 'Mbarara',
                    'gulu' => 'Gulu',
                    'lira' => 'Lira',
                    'masaka' => 'Masaka',
                    'other' => 'Other',
                ])->required(),
                Forms\Components\TextInput::make('subcounty')->required(),
                Forms\Components\TextInput::make('parish'),
                Forms\Components\TextInput::make('village')->required(),
                // Cooperative/Group Information
                Forms\Components\TextInput::make('cooperativeName')->required(),
                Forms\Components\TextInput::make('membershipNumber'),
                Forms\Components\Select::make('position')->options([
                    'chairperson' => 'Chairperson',
                    'secretary' => 'Secretary',
                    'treasurer' => 'Treasurer',
                    'committee_member' => 'Committee Member',
                    'ordinary_member' => 'Ordinary Member',
                ]),
                Forms\Components\TextInput::make('registrationNumber'),
                // Agricultural Information
                Forms\Components\Select::make('primaryCrop')->options([
                    'coffee' => 'Coffee',
                    'maize' => 'Maize',
                    'beans' => 'Beans',
                    'rice' => 'Rice',
                    'groundnuts' => 'Groundnuts',
                    'cassava' => 'Cassava',
                    'sweet_potatoes' => 'Sweet Potatoes',
                    'bananas' => 'Bananas',
                    'other' => 'Other',
                ])->required(),
                Forms\Components\TextInput::make('otherCrop'),
                Forms\Components\TextInput::make('farmSize')->numeric()->required(),
                Forms\Components\TextInput::make('annualProduction')->numeric(),
                Forms\Components\TextInput::make('farmingExperience')->numeric(),
                // Financial Information
                Forms\Components\TextInput::make('loanAmount')->numeric()->required(),
                Forms\Components\Select::make('loanPurpose')->options([
                    'harvest_advance' => 'Harvest Advance',
                    'asset_acquisition' => 'Asset Acquisition',
                    'value_chain' => 'Value Chain Financing',
                    'working_capital' => 'Working Capital',
                ])->required(),
                Forms\Components\TextInput::make('monthlyIncome')->numeric(),
                Forms\Components\Select::make('bankAccount')->options([
                    'yes' => 'Yes',
                    'no' => 'No',
                ])->required(),
                // Consent and Declarations
                Forms\Components\Toggle::make('dataConsent')->required(),
                Forms\Components\Toggle::make('creditCheck')->required(),
                Forms\Components\Toggle::make('termsAccept')->required(),
                Forms\Components\Toggle::make('accurateInfo')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstName')->searchable(),
                Tables\Columns\TextColumn::make('lastName')->searchable(),
                Tables\Columns\TextColumn::make('phoneNumber'),
                Tables\Columns\TextColumn::make('district'),
                Tables\Columns\TextColumn::make('cooperativeName'),
                Tables\Columns\TextColumn::make('primaryCrop'),
                Tables\Columns\TextColumn::make('loanAmount')->money('UGX'),
                Tables\Columns\TextColumn::make('loanPurpose'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }    
}
