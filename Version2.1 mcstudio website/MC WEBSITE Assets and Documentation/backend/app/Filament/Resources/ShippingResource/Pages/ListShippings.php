<?php

namespace App\Filament\Resources\ShippingResource\Pages;

use App\Filament\Resources\ShippingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListShippings extends ListRecords
{
    protected static string $resource = ShippingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->uniqueField('shipping_area')
            ->massCreate(false)
            ->handleBlankRows(true)
                ->fields([
                    ImportField::make('shipping_area')
                        ->label('Shipping Area')
                        ->required()
                        ->helperText('Name of dropoff location'),
                    ImportField::make('shipping_cost')
                        ->required()
                        ->label('Shipping Cost'),
                    ImportField::make('method')
                       ->helperText('Name of courier')
                        ->label('Shipping Method'),
                    ImportField::make('currency')
                        ->helperText('Currency')
                         ->label('Currency'),
                ])
        ];
    }
}
