<?php

namespace App\Filament\Resources\PurchaseOrderResource\Pages;

use App\Events\SystemEvent;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PurchaseOrderResource;
use Filament\Facades\Filament;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function afterCreate(): void
    {
        $pOrder = $this->record;

        $itemTotals = $pOrder->items->sum(fn ($item): float => (float) ($item->cost_price * $item->qty));
        
        $pOrder->update([
            'total_price' => $itemTotals
        ]);

        event( new SystemEvent($this->getModel()::find($this->record->id), 'create_purchase_order'));
    }

    protected function getRedirectUrl(): string
    {
        if(Filament::auth()->user()->can('update purchase orders')){
            return $this->getResource()::getUrl('edit', ['record' => $this->record]);
        }
        return $this->getResource()::getUrl('view');
    }
}
