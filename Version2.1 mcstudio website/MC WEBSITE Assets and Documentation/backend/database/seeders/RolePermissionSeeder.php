<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call('app:permissions-generate');
        Artisan::call('app:permissions-sync --role=Admin');
        Artisan::call('app:assign-role hello@kijani.co Admin');
        
    }
}
