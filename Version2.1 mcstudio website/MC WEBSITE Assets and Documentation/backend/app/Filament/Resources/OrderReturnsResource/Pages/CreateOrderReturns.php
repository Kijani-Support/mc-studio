<?php

namespace App\Filament\Resources\OrderReturnsResource\Pages;

use App\Events\SystemEvent;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\OrderReturnsResource;

class CreateOrderReturns extends CreateRecord
{
    protected static string $resource = OrderReturnsResource::class;

    public function afterCreate(): void
    {
        event( new SystemEvent($this->getModel()::find($this->record->id), 'create_order_return'));
    }
}
