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

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => 'https://a8de-5-178-226-225.eu.ngrok.io/api/auth/facebook/callback/1',
    ],

    'google' => [
        'client_id' => '705925040372-viam3g2ovalc6cjlggckim7kah0trmrc.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://a8de-5-178-226-225.eu.ngrok.io/api/auth/google/callback/1',
    ],

];
