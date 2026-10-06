<?php

namespace App\Providers;

use App\View\Components\MailBase;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::component('mail.base', MailBase::class);

        View::composer('partials.mail.header', function ($view) {

            $view->with('logo', \App\Models\BusinessSettings::first()?->media()->first()?->original_url);
            
        });
    }
}
