<?php

namespace App\Filament\Resources\EmailSettingResource\Pages;

use App\Filament\Resources\EmailSettingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmailSetting extends EditRecord
{
    protected static string $resource = EmailSettingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
