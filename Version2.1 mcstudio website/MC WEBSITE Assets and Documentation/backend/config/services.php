<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'lisa' => [
        'authToken' => env('LISA_AUTH_TOKEN'),
        'base_url'  => env('LISA_BASE_URL'),
        'devId'     => env('LISA_DEVELOPER_ID'),
        'businessId'     => env('LISA_BUSINESS_ID'),
    ],

    'lotus' => [
       'baseurl' => env('LOTUS_ENDPOINT'),
       'apikey' => env('LOTUS_APIKEY')
    ],

    'zettatel' => [
        'apikey' => env('ZETTATEL_APIKEY'),
        'userid' => env('ZETTATEL_USERID'),
        'password' => env('ZETTATEL_PASSWORD'),
        'senderid' => env('ZETTATEL_SENDERID'),
        'baseurl' =>env('ZETTATEL_BASEURL')
    ],

];
