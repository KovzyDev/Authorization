<?php

//Configuration payment payze
return [
    'payze' => [
        'api_endpoint' => 'https://payze.io/',
        'success' => '/payment/payze/success',
        'fail' => '/payment/payze/fail',
        'callback_url' => '/payment/payze/callback',
        'apiKey' => env('test', 'A5ED1E0875254AE389AAF585F5BE3F11'),
        'apiSecret' => env('test', 'EF28150C7D2144A89C64CC2B140F4018')
    ]
];
