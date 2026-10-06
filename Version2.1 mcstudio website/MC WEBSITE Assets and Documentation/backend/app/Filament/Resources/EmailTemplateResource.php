<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailTemplateResource\Pages;
use App\Filament\Resources\EmailTemplateResource\RelationManagers;
use App\Forms\Components\DataField;
use App\Models\EmailTemplate;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Livewire\Component as Livewire;

class EmailTemplateResource extends Resource
{
    protected static ?string $model = EmailTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationGroup = 'Business Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Card::make()
            ->schema([
                Forms\Components\Select::make('record type')
                ->options([
                    'create_quotation' => 'Create Quotation',
                    'create_customer' => 'Create Customer',
                    'create_order' => 'Create Order',
                    'create_purchase_order' => 'Create Purchase Order',
                    'create_stock_return' => 'Create Stock Return',
                    'create_order_return' => 'Create Order Return',
                    'create_supplier' => 'Create Supplier',
                ])
                ->required()
                ->disabledOn('edit'),
                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->unique(ignorable: fn ($record) => $record)
                    ->maxLength(255),

                Forms\Components\Card::make()
                    ->schema([
                        DataField::make('column_fields')
                        ->description('These are the dynamic fields that are available for this template')
                        ->items(function(Component $component){
                            return $component->getLivewire()->column_fields;
                        })
                        ->view('forms.components.email-template-data-field')
                        ->visibleOn('edit')
                    ])
                    ->hidden(function(Component $component){
                        $hasColumnFields = $component->getLivewire()->column_fields ?? false;
                        return !$hasColumnFields;
                    })
                    ->visibleOn('edit'),

                Forms\Components\RichEditor::make('body')
                    ->required()
                    ->columnSpan('full'),
            ])
          ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('record type')
                    ->getStateUsing(function (Model $record){
                        return Str::of($record['record type'])->title()->replace('_',' ');
                    })
                    ->searchable(isIndividual: true)
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
            'index' => Pages\ListEmailTemplates::route('/'),
            'create' => Pages\CreateEmailTemplate::route('/create'),
            'edit' => Pages\EditEmailTemplate::route('/{record}/edit'),
        ];
    }
}
