<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use Illuminate\Database\Eloquent\Model;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->uniqueField('sku')
            ->massCreate(false)
            ->handleBlankRows(true)
                ->fields([
                    ImportField::make('name')
                        ->label('Name')
                        ->required()
                        ->helperText('Product Name'),
                    ImportField::make('sku')
                        ->required()
                        ->label('SKU'),
                    ImportField::make('description')
                        ->label('Description'),
                    ImportField::make('price')
                        ->required()
                        ->label('Price'),
                    ImportField::make('cost')
                        ->label('Cost'),
                    ImportField::make('barcode')
                        ->label('Barcode'),
                    ImportField::make('qty')
                        ->required()
                        ->label('Quantity'),
                ])
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return ProductResource::getWidgets();
    }
}
