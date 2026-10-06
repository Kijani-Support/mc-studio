<?php

namespace App\Filament\Resources\BusinessSettingsResource\Pages;

use App\Filament\Resources\BusinessSettingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBusinessSettings extends CreateRecord
{
    protected static string $resource = BusinessSettingsResource::class;

    protected static bool $canCreateAnother = false;
    
}
