<?php

namespace App\Filament\Resources\StockReturnResource\Pages;

use App\Events\SystemEvent;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\StockReturnResource;

class CreateStockReturn extends CreateRecord
{
    protected static string $resource = StockReturnResource::class;

    public function afterCreate(): void
    {
        event( new SystemEvent($this->getModel()::find($this->record->id), 'create_stock_return'));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // $data['user_id'] = $data['supplier_id'];
        $data['order_id'] = $data['purchase_order_id'];

        // dd($data);
    
        return $data;
    }
}
