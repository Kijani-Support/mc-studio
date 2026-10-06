<?php

namespace App\Contracts;

interface SmsInterface
{
    public function send($data);
}
