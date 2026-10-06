<?php

use App\Filament\Pages\LoginWithLink;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\SubscriptionExpired;
use Filament\Http\Middleware\Authenticate;
use App\Http\Middleware\EnsureAccountIsNotExpired;
use App\Http\Middleware\EnsureUserHasChangedPassword;
use App\Http\Controllers\LeadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
    // return redirect(route('filament.auth.login'));
});

Route::get('login', function () {
    return redirect(route('filament.auth.login'));
})->withoutMiddleware([EnsureAccountIsNotExpired::class])->name('login');

// Route::get(config('filament.path').'/account')->name('filament.pages.account')->withoutMiddleware([EnsureUserHasChangedPassword::class]);

Route::domain(config('filament.domain'))
    ->middleware(config('filament.middleware.base'))
    ->prefix(config('filament.path'))
    ->name('filament.')
    ->group(function (): void {
        // Route::get('/auth/{user}',  LoginWithLink::class)->middleware(['signed'])->name('login.token');
        Route::get('/auth/subscription/expired', SubscriptionExpired::class)->withoutMiddleware([EnsureAccountIsNotExpired::class])->name('account.expired');
    });

Route::post('webhook/payment', WebhookController::class)->name('webhook.payment');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
Route::post('/applications', [App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
