<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(){
        $product = $this->record;

        $total_stock = $product->warehouses->sum(function($item){
            return $item->pivot->qty;
        });

        $product->update([
            'qty' => $total_stock,
        ]);

        $this->fillForm();
        $this->emit('updateWarehouse');
    }
}
