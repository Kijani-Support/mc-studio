<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Models\User;
use App\Events\SystemEvent;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CustomerResource;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function afterCreate(): void
    {
        if(!$role = Role::where('name', 'customer')->first()){
            $role = Role::create(['name' => 'customer']);
        }

        $this->record->assignRole($role);

        event( new SystemEvent($this->getModel()::find($this->record->id), 'create_customer'));
    }
}
