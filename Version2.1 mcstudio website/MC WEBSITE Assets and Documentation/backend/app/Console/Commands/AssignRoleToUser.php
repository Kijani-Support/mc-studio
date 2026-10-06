<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignRoleToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-role {user?} {role?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigns a role to a user';

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
     */
    public function handle():void 
    {
        $user = User::whereEmail($this->argument('user') ? $this->argument('user') : $this->ask("Please enter the email address of the user"))->first();
        $role = $this->argument('role') ? $this->argument('role') : $this->choice("Please choose the role you wish to add to the user", Role::pluck('name')->toArray());

        $user->assignRole($role);
        $this->info(sprintf("Role `%s` assigned to user `%s`", $role, $user->email));
    }
}
