<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SetUpNonAdminUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-basic-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up roles for non admin users and assign default permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // create employee role
        if($employee = Role::firstOrCreate(['name' => 'Employee'])){
            
            $perms = Permission::where('name','like', '%list%')
                                ->orWhere('name', 'like', '%create%')
                                ->orWhere('name', 'like', '%update%')
                                ->get()
                                ->filter(fn($item) => !Str::of($item->name)->contains(['roles','permissions']) );
            $employee->givePermissionTo($perms);
        }
        
        // create customer role
        if($customer = Role::firstOrCreate(['name' => 'Customer'])){
            $customer->givePermissionTo([
                'list orders',
                'list quotations'
            ]);
        }
        
        // create supplier role
        if($supplier = Role::firstOrCreate(['name' => 'Supplier'])){
            $supplier->givePermissionTo([
                'list purchase orders',
                'list stock returns'
            ]);
        }
    }
}
