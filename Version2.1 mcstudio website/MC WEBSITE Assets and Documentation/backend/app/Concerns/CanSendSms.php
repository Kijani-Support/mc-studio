<?php

namespace App\Concerns;

use App\Models\SmsTemplate;

trait CanSendSms
{
    public function resolveSms(): SmsTemplate
    {
        return SmsTemplate::where('record type', $this->template)->first();
    }

    public function toSms(object $notifiable): object
    {
        return (object)[
            'mobile'  => $notifiable->phone_number,
            'message' => strip_tags($this->resolveSms()?->body)
        ];
    }
}
