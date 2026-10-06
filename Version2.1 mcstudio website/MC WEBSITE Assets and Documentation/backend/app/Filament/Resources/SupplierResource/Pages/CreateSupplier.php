<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Events\SystemEvent;
use Filament\Pages\Actions;
use Spatie\Permission\Models\Role;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SupplierResource;

class CreateSupplier extends CreateRecord
{
    protected static string $resource = SupplierResource::class;

    protected function afterCreate(): void
    {
        if(!$role = Role::where('name', 'supplier')->first()){
            $role = Role::create(['name' => 'supplier']);
        }
        
        $this->record->assignRole($role);
        event( new SystemEvent($this->getModel()::find($this->record->id), 'create_supplier'));
    }
}
