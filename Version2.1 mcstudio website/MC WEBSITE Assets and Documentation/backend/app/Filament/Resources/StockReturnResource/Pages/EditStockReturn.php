<?php

namespace App\Filament\Resources\StockReturnResource\Pages;

use App\Filament\Resources\StockReturnResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockReturn extends EditRecord
{
    protected static string $resource = StockReturnResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
