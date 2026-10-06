<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Events\SystemEvent;
use App\Filament\Resources\UserResource;
use App\Models\EmailTemplate;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $user = $this->record;
        $role = $user->roles?->first()->name;

        if($role){
            switch ( strtolower($role) ) {
                case 'admin':
                    $template = 'create_admin';
                    break;
                case 'customer':
                    $template = 'create_customer';
                    break;
                case 'supplier':
                    $template = 'create_supplier';
                    break;
                case 'employee':
                    $template = 'create_employee';
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        event( new SystemEvent($this->getModel()::find($this->record->id), $template));
    }
}
