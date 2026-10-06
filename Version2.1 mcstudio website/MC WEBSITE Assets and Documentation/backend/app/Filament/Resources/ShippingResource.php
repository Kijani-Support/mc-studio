<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShippingResource\Pages;
use App\Filament\Resources\ShippingResource\RelationManagers;
use App\Models\Shipping;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Squire\Models\Currency;

class ShippingResource extends Resource
{
    protected static ?string $model = Shipping::class;

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?int $navigationSort = 5;

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
                        ->columnSpan(['lg' => fn (?Shipping $record) => $record === null ? 3 : 2]),
                    

                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn (Shipping $record): ?string => $record->created_at?->diffForHumans()),

                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn (Shipping $record): ?string => $record->updated_at?->diffForHumans()),
                        ])
                        ->columnSpan(['lg' => 1])
                        ->hidden(fn (?Shipping $record) => $record === null),
                ])
        ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('method')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('shipping_area')
                ->searchable()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('shipping_cost')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('currency')
                ->getStateUsing(fn ($record): ?string => Currency::find($record->currency)?->name ?? null)
                ->searchable()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created Date')
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
    public static function getFormSchema(?string $section = null): array
    {
        return [
            Forms\Components\TextInput::make('shipping_area')
                ->label('Shipping Area')
                ->required(),

            Forms\Components\TextInput::make('shipping_cost')
                ->label('Shipping Cost')
                ->required(),

            Forms\Components\Select::make('method')
                ->options([
                    'Inhouse' => 'In House',
                    'Courier' => 'Courier',
                ])
                ->required(),
            Forms\Components\Select::make('currency')
                ->searchable()
                ->getSearchResultsUsing(fn (string $query) => Currency::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                ->getOptionLabelUsing(fn ($value): ?string => Currency::find($value)?->getAttribute('name'))
                //->default('kes')
                ->required(),

        ];
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShippings::route('/'),
            'create' => Pages\CreateShipping::route('/create'),
            'edit' => Pages\EditShipping::route('/{record}/edit'),
        ];
    }    
}
