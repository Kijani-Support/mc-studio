<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate fresh db and seed it';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
    	if(app()->env !== 'production'){
        $this->call('migrate:fresh');
        $this->call('db:seed');
        $this->call('app:setup-basic-users');
    	}
    }
}
