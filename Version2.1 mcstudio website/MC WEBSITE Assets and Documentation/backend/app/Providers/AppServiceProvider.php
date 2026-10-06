<?php

namespace App\Providers;

use App\Api\Zettatel;
use App\Channels\SmsChannel;
use App\Contracts\PaymentGatewayInterface;
use App\Contracts\SmsInterface;
use App\PaymentGateways\Lotus;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Filament\Responses\LoginLinkResponse;
use App\Filament\Responses\Contracts\LoginResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // custom login with token
        $this->app->bind(LoginResponse::class, LoginLinkResponse::class);

        $this->registerMacros();

        $this->registerSmsNotification();

        // $this->registerPaymentGateway();

        // set user password
        $password_gen = app()->environment('production') ? Hash::make(Str::password(10)) : Hash::make('password');
        config()->set('helpers.password_gen', $password_gen);

        // set css inliner path
        config()->set('css-inliner.css-files', [Vite::asset('resources/css/mail.css')]);

        // add slack logger if available
        if( !is_null(env('LOG_SLACK_WEBHOOK_URL')) ){
            config()->set('logging.channels.stack.channels', ['single', 'slack']);
        }

    }

    public function registerSmsNotification(): void
    {
        $this->app->bind(SmsInterface::class, Zettatel::class);

        Notification::resolved(function(ChannelManager $service){
            $service->extend('sms', function ($app){
                return new SmsChannel($app);
            });
        });
    }

    // public function registerPaymentGateway(): void
    // {
    //     $this->app->bind(PaymentGatewayInterface::class, Lotus::class);
    // }

    public function registerMacros(): void
    {
        // Add recursive macro
        Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });

        // add a lotus client macro
        // Http::macro('lotus', function(){
        //     return Http::withHeaders([
        //                     'Authorization' => 'Token ' .config('services.lotus.apikey'),
        //                     'Accept' => 'application/json',
        //                     'Content-Type' => 'application/json'
        //                 ])
        //                 ->baseUrl(config('services.lotus.baseurl'));
        // });
    }
}
