<?php

namespace App\Filament\Resources\AccountDetailsResource\Pages;

use App\Filament\Resources\AccountDetailsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountDetails extends EditRecord
{
    protected static string $resource = AccountDetailsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
