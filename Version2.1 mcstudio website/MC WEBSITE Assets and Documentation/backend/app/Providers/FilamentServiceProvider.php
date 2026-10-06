<?php

namespace App\Providers;

use App\Filament\Widgets\DayWidget;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Livewire\Livewire;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Filament::serving(function () {
         
           Filament::registerViteTheme('resources/css/filament.css');

           Filament::registerUserMenuItems([
            'account' => UserMenuItem::make()->url(route('filament.pages.account'))->label('My Account'),
            ]);

            Livewire::component('timex-day-widget',DayWidget::class);

        });

    }
}
