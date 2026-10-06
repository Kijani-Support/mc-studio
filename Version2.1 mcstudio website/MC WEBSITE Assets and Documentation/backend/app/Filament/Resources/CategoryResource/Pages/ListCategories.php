<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->massCreate(false)
            ->handleBlankRows(true)
            ->uniqueField('name')
            ->fields([
                ImportField::make('name')
                    ->label('Name')
                    ->required()
                    ->helperText('Category Name'),
                ImportField::make('description')
                    ->label('Description')
                    ->helperText('Description'),
            ])
        ];
    }
}
