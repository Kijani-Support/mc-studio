<?php

namespace App\Filament\Pages;

use Closure;
use App\Models\User;
use Livewire\Component;
use Filament\Pages\Page;
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use App\Filament\Responses\Contracts\LoginResponse;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Http\Middleware\Authenticate as MiddlewareAuthenticate;

class LoginWithLink extends Page
{
    use WithRateLimiting;
    protected static string $view = 'livewire.login-token';

    protected static ?string $title = 'Authenticate';
    
    protected static bool $shouldRegisterNavigation = false;

    public $user;

    public function mount(Request $request, User $user)
    {

        if (Filament::auth()->check()) {
            redirect()->route('filament.pages.account');
        }
        $this->user = $user;
        $this->authenticate();
    }

    
    public static function getRoutes(): Closure
    {
        return function () {
            Route::get('/auth/{user}', static::class)
            ->name('login.token')
            ->middleware('signed:consume')
            ->withoutMiddleware([
                MiddlewareAuthenticate::class
            ]);
        };
    }

    public function authenticate()
    {
        if(!$user = Filament::auth()->loginUsingId($this->user->id)){
            logger('did not log in');
        }
        
        session()->regenerate();

        return app(LoginResponse::class);
    }

    public function render(): View
    {
        return view('livewire.login-token');
    }

}
