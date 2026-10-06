<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->massCreate(true)
            ->handleBlankRows(true)
            ->mutateAfterCreate(function(Model $model, $row){
                if(!$role = Role::where('name', 'customer')->first()){
                    $role = Role::create(['name' => 'customer']);
                }
                $model->assignRole($role);
                return $model;
            })
            ->fields([
                ImportField::make('name')
                    ->label('Name')
                    ->helperText('Customer Name')
                    ->required(),
                ImportField::make('email')
                    ->label('Email')
                    ->required()
                    ->helperText('Email Address'),
                ImportField::make('phone_number')
                    ->label('Phone')
                    ->helperText('Phone Number'),
            ])
        ];
    }
}
