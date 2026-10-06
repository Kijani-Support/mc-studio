<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsNotExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): mixed
    {
        
        $admin = Admin::first();
        
        if ($admin && $admin->isExpired()) {
            
            if(request()->routeIs('filament.auth.login')){
                return Redirect::guest(URL::route('filament.account.expired'));
                // return $next($request);
            }

            Filament::auth()->logout();

            return Redirect::guest(URL::route('filament.account.expired'));
        }

        return $next($request);
    }
}
