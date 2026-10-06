<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'Spatie\Permission\Models\Role' => 'App\Policies\RolePolicy',
        'Spatie\Permission\Models\Permission' => 'App\Policies\PermissionPolicy',
        'Spatie\Activitylog\Models\Activity' => 'App\Policies\ActivityPolicy',
        'Buildix\Timex\Models\Event' => 'App\Policies\TimexEventPolicy',
        'Sgcomptech\FilamentTicketing\Models\Ticket' => 'App\Policies\TicketPolicy',
        // 'App\Models\User' => 'App\Policies\CustomerPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
