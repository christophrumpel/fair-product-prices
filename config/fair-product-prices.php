<?php

return [
    /*
    |--------------------------------------------------------------------------
    | You can override the ppp conversion factor for specific countries
    |--------------------------------------------------------------------------
    |
    */
    'pppConversionFactor' => [
        'DE' => 0.8
    ],

    /*
    |--------------------------------------------------------------------------
    | Paddle credentials for creating a Paddle pay link
    |--------------------------------------------------------------------------
    |
    */
    'paddle' => [
        'vendor_id' => env('PADDLE_VENDOR_ID'),
        'auth_code' => env('PADDLE_AUTH_CODE'),
    ]

];
