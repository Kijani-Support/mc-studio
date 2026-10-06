<?php

namespace App\Filament\Resources\OrderReturnsResource\Pages;

use App\Filament\Resources\OrderReturnsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderReturns extends ListRecords
{
    protected static string $resource = OrderReturnsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
