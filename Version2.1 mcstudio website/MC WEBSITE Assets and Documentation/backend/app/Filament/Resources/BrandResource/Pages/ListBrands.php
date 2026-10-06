<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

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
                    ->helperText('Brand Name')
                    ->required(),
                ImportField::make('website')
                    ->label('Website'),
                ImportField::make('description')
                    ->label('Description'),
            ])
        ];
    }
}
