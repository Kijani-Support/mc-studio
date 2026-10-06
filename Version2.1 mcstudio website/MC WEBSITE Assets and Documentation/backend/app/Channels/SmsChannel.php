<?php

namespace App\Channels;

use App\Api\Zettatel;
use App\Contracts\SmsInterface;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (! method_exists($notification, 'toSms')) {
            return;
        }

        $data = $notification->toSms($notifiable);

        $sms = $this->app->make(SmsInterface::class);

        $sms->send($data);

    }
}
