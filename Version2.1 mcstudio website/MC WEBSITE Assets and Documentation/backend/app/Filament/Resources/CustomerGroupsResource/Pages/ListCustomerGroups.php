<?php

namespace App\Filament\Resources\CustomerGroupsResource\Pages;

use App\Filament\Resources\CustomerGroupsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerGroups extends ListRecords
{
    protected static string $resource = CustomerGroupsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
