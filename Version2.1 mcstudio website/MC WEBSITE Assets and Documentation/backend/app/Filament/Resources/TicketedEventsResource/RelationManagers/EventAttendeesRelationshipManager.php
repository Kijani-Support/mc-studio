<?php

namespace App\Filament\Resources\TicketedEventsResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventAttendeesRelationshipManager extends RelationManager
{
    protected static string $relationship = 'attendees';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('qty')
                    ->numeric()
                    ->label('Quantity')
                    ->required(),
                Forms\Components\TextInput::make('payment_ref')
                    ->label('Payment Reference')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name') ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('email') ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('phone') ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('qty'),
                Tables\Columns\TextColumn::make('payment_ref') ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Add attendee'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('Edit attendee'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                ->label('Delete attendee'),
            ]);
    }    
}
