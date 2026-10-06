<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup entire database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {

            $path = storage_path('db/backup/');

            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }
            
            $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql.gz";
    
            $command  = "mysqldump --user=" . config('database.mysql.username') ." --password=" . config('database.mysql.username') . " --host=" . config('database.mysql.host') . " " . config('database.mysql.database') . "  | gzip > " . $path. '/' . $filename;
    
            $returnVar  = NULL;
            $output     = NULL;
    
            exec($command, $output, $returnVar);

        } catch (\Throwable $th) {
            logger('could not create db backup');
            logger($th->getMessage());
        }
    }
}
