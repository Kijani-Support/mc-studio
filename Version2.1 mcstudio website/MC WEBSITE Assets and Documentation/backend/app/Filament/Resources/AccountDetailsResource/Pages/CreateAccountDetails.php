<?php

namespace App\Filament\Resources\AccountDetailsResource\Pages;

use App\Filament\Resources\AccountDetailsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccountDetails extends CreateRecord
{
    protected static string $resource = AccountDetailsResource::class;
}
