<?php

namespace App\Filament\Resources\EmailSettingResource\Pages;

use App\Filament\Resources\EmailSettingResource;
use App\Models\EmailSetting;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmailSettings extends ListRecords
{
    protected static string $resource = EmailSettingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        if($emailSettings = EmailSetting::first()){
            $this->redirect($this->getResource()::getUrl('edit', ['record' => $emailSettings]));
        }else{
            $this->redirect($this->getResource()::getUrl('create'));
        }
    }
}
