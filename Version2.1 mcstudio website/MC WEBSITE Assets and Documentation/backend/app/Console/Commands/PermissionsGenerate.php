<?php

namespace App\Console\Commands;

use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;

class PermissionsGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:permissions-generate {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD permissions for models';
    
    
    /**
     * Any extra models that need permissions outside the App namespace.
     *
     * @var array
     */
    protected $extraModels = [
        Role::class,
        Permission::class,
        Activity::class,
    ];
    
    /**
     * CRUD methods to be added to a permission.
     *
     * @var array
     */
    protected $crud = [
        'create',
        'list',
        'update',
        'delete',
    ];


    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        if($model = $this->argument('model')){
            
            $this->genSinglePerm($model);

        }else{
            
            $this->genAllPerms();

        }
    }

    /**
     * Generate permission for single Model
     * 
     * @var $model
     * 
     */
    public function genSinglePerm($model):void
    {
        try {
                
            $reflection = new ReflectionClass($model);
            $class = strtr(substr($reflection->getName(), 0),  '/', '\\');

            $name   = last(explode('\\', $class));
            $split  = Str::snake($name, ' ');
            $plural = Str::plural($split);

            $crudList = collect($this->crud)->map(function($item) use($plural){
                return $item .' '. $plural;
            });

            $insertItems = $crudList->map(function($item){
                return ['name' => $item];
            })->toArray();

            $p = Permission::upsert($insertItems, ['name']);

            $this->info("Generated Permissions for $model model");

        } catch (\Throwable $th) {
            $this->info($th->getMessage());
            $this->error('Try passing in the Full Qualified Class Name (with namespace)');
        }
    }
    
    
     /**
     * Generate permissions for all desired models
     * 
     */
    public function genAllPerms():void
    {
        try {
            $models = $this->getModels();

            $modelNames = $models->map(function($model){
                $name   = last(explode('\\', $model));
                $split  = Str::snake($name, ' ');
                $plural = Str::plural($split);
                
                return $plural;
            });

            $permNames = collect([$modelNames, ...$this->getRoles()])->flatten();

            $crudList = $permNames->map(function($model){
                return collect($this->crud)->map(function($item) use($model){
                    return $item .' '. $model;
                });
            })->flatten();

            $insertItems = $crudList->map(function($item){
                return ['name' => $item];
            })->toArray();

            // ticket permissions
            $ticketPerms = collect(['manage all permissions', 'assign tickets', 'manage assigned tickets'])->map(function($item){
                return ['name' => $item];
            })->toArray();

            $insertPerms = array_merge($insertItems, $ticketPerms);

            $p = Permission::upsert($insertPerms, ['name']);

            $this->info('Generated Permissions from all models');
            
        } catch (\Throwable $th) {
            $this->info($th->getMessage());
        }
    }
    
     /**
     * Get application models
     */
    public function getModels(): Collection
    {
        $models = collect(File::allFiles(app_path()))
            ->map(function ($item) {
                $path = $item->getRelativePathName();
                $class = sprintf('\%s%s',
                    Container::getInstance()->getNamespace(),
                    strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));

                return $class;
            });

        $merged = $models->merge(
            collect($this->extraModels)->map(function($item){
                $reflection = new ReflectionClass($item);
                $class = strtr(substr($reflection->getName(), 0),  '/', '\\');
                return $class;
            })
        );

       

        $filtered_models = $merged->filter(function ($class) {
            $valid = false;

            if (class_exists($class)) {
                $reflection = new \ReflectionClass($class);
                $valid = $reflection->isSubclassOf(Model::class) &&
                    !$reflection->isAbstract();
            }

            return $valid;
        });

        return $filtered_models->values();
    }

    public function getRoles(): array 
    {
        if(! $roles = Role::all()) return [];

        return $roles->pluck('name')
                     ->map(fn($item) => Str::of($item)->lower()->plural()->value())
                     ->toArray();
    }
}
