<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:permissions-sync {--role=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the permissions.';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->call('app:permissions-generate');

        $this->call('permission:cache-reset');

        if ($roles = $this->option('role')) {
            $synced = 0;
            $permissions = Permission::get();
            foreach ($roles as $key => $roleName) {
                $role = Role::firstOrCreate(['name' => $roleName]);
                foreach ($permissions as $key => $permission) {
                    $role->givePermissionTo($permission->name);
                    $synced++;
                }
            }

            $this->line("Synced $synced permissions");
        }
    }
}
