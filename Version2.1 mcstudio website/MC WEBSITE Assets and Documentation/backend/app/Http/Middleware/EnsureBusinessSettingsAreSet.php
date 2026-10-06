<?php

namespace App\Http\Middleware;

use App\Models\BusinessSettings;
use Closure;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Symfony\Component\HttpFoundation\Response;

class EnsureBusinessSettingsAreSet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Filament::auth()->user() && Filament::auth()->user()->roles->first()->name === 'Admin')
        {
            if(request()->routeIs('filament.resources.business-settings.create')){
                return $next($request);
            }
            if(!BusinessSettings::first())
            {
                Filament::notify('warning','Please set your business details to continue accessing the site', true);
                return redirect(route('filament.resources.business-settings.create'));
            }
        }
        return $next($request);
    }
}
