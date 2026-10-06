<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kijani:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup a fresh application';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $choice = $this->choice('Please select the type of app', ['Demo App', 'Live App'], 0);

        $this->info('Selected: '.$choice);

        // if demo mode
        if($choice === 'Demo App'){
            // new up database columns and seed data
            $this->info('Setting up new Demo App 🌱');
            $this->call('migrate:seed');
            $this->info('Setting up new Demo App - DONE 🌳');
            
        }else{
            // new up database columns
            $this->info('Setting up database columns 🌱');
            $this->call('migrate:fresh');
            $this->info('Setting up database columns - DONE 🌳');

            // seed admin user
            $this->info('Setting up admin user 🌱');
            (new \Database\Seeders\UserSeeder)->run();
            
            // generate permissions and assign role to admin user

            // generate permissions
            $this->info('Generating app permissions 🌱');
            $this->call('app:permissions-sync', ['--role' => ['Admin']]);
            $this->info('Generating app permissions - DONE 🌳');

            // assign role
            Artisan::call('app:assign-role hello@kijani.co Admin');
            $this->info('Setting up admin user - DONE 🌳');

            // create user roles and assign permissions
            $this->call('app:setup-basic-users');

            // seed admin user
            $this->info('Setting up email templates 🌱');
            (new \Database\Seeders\EmailTemplateSeeder)->run();
            $this->info('Setting up email templates - DONE 🌳'); 
            
            // seed warehouse
            $this->info('Setting up initial warehouse 🌱');
            (new \Database\Seeders\WarehouseSeeder)->run();
            $this->info('Setting up up initial warehouse - DONE 🌳');
            

            $this->info('New Live App has been setup 🌳');
        }

    }
}
