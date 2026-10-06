<?php

namespace App\Filament\Resources\BusinessSettingsResource\Pages;

use App\Filament\Resources\BusinessSettingsResource;
use App\Models\BusinessSettings;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBusinessSettings extends ListRecords
{
    protected static string $resource = BusinessSettingsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        if($businessSettings = BusinessSettings::first()){
            $this->redirect($this->getResource()::getUrl('edit', ['record' => $businessSettings]));
        }else{
            $this->redirect($this->getResource()::getUrl('create'));
        }
    }
}
