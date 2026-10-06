<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasChangedPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if(Filament::auth()->user())
        {
            if(request()->routeIs('filament.pages.account')){
                return $next($request);
            }
            if(!Filament::auth()->user()->changed_initial_password)
            {
                Filament::notify('warning','Please change your password to continue accessing the site', true);
                return redirect(route('filament.pages.account'));
            }
        }
        return $next($request);
    }
}
