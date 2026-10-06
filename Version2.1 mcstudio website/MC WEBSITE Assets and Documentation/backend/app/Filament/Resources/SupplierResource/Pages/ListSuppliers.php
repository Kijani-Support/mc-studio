<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Filament\Resources\SupplierResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ListSuppliers extends ListRecords
{
    protected static string $resource = SupplierResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->massCreate(false)
            ->handleBlankRows(true)
            ->uniqueField('email')
            ->mutateAfterCreate(function(Model $model, $row){
                if(!$role = Role::where('name', 'supplier')->first()){
                    $role = Role::create(['name' => 'supplier']);
                }
                $model->assignRole($role);
                return $model;
            })
            ->fields([
                ImportField::make('name')
                    ->label('Name')
                    ->required()
                    ->helperText('Supplier Name'),
                ImportField::make('email')
                    ->label('Email')
                    ->required()
                    ->helperText('Email Address'),
                ImportField::make('phone')
                    ->label('Phone')
                    ->helperText('Phone Number'),
            ])
        ];
    }
}
