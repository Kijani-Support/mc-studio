<?php

namespace App\Providers;

use App\Models\EmailSetting;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
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
        if(!app()->runningInConsole()){
            if($mailSetting = EmailSetting::first()){
                config()->set([
                    'mail.mailers.smtp.host' => $mailSetting->host,
                    'mail.mailers.smtp.port' => $mailSetting->port,
                    'mail.mailers.smtp.username' => $mailSetting['email-address'],
                    'mail.mailers.smtp.password' => $mailSetting->password,
                    'mail.from.address' => $mailSetting->sender,
                    'mail.from.name' => $mailSetting->from_name,
                ]);
            }
        }

    }
}
