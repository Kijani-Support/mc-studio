<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketedEventsResource\Pages;
use App\Filament\Resources\TicketedEventsResource\RelationManagers;
use App\Models\TicketedEvents;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\TicketedEventsResource\RelationManagers\EventAttendeesRelationshipManager;

class TicketedEventsResource extends Resource
{
    protected static ?string $model = TicketedEvents::class;


    protected static ?string $slug = 'events';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('event_name')
                                    ->required()
                                    ->lazy(),

                                Forms\Components\MarkdownEditor::make('event_description')
                                    ->columnSpan('full'),
                                
                                Forms\Components\TextInput::make('event_location')
                                    ->required()
                                    ->lazy(),

                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),
                                
                                Forms\Components\TextInput::make('qty')
                                    ->label('Maximum Attendees')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\DatePicker::make('event_startdate')
                                    ->label('Start Date')
                                    ->default(now())
                                    ->required(),
                                Forms\Components\DatePicker::make('event_enddate')
                                    ->label('End Date')
                                    ->default(now())
                                    ->required(),
                            ])
                            ->columnSpan(['lg' => fn (?TicketedEvents $record) => $record === null ? 3 : 2]),

                        Forms\Components\Section::make('Images')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->collection('event-images')
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->disableLabel(),
                            ])
                            ->collapsible(),
                        
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('event-image')
                    ->label('Image')
                    ->collection('event-images'),

                Tables\Columns\TextColumn::make('event_name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('event_location')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('event_startdate')
                    ->label('Start Date')
                    ->date()
                    ->sortable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('event_enddate')
                    ->label('End Date')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function () {
                        Notification::make()
                            ->title('Now, now, don\'t be cheeky, leave some records for others to play with!')
                            ->warning()
                            ->send();
                    }),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            EventAttendeesRelationshipManager::class
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTicketedEvents::route('/'),
            'create' => Pages\CreateTicketedEvents::route('/create'),
            'edit' => Pages\EditTicketedEvents::route('/{record}/edit'),
        ];
    }    
}
