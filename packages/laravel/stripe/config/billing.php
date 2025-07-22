<?php

use Honed\Billing\Period;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Billing Driver
    |--------------------------------------------------------------------------
    |
    | Here you will specify the default driver that should be used when
    | resolving your plans and products. 
    |
    | Supported: "config"
    |
    */
    'default' => env('BILLING_DRIVER', 'config'),

    /*
    |--------------------------------------------------------------------------
    | Billing Drivers
    |--------------------------------------------------------------------------
    |
    | Here you may configure each of the drivers that should be available 
    | to retrieve your plans and products.
    |
    */

    'drivers' => [
        'config' => [
            'driver' => 'config',
        ],

        'database' => [
            'driver' => 'database',
            'connection' => null,
            'table' => 'products'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Billing Drivers
    |--------------------------------------------------------------------------
    |
    | If you are using the `config` driver, you may specify your plans and
    | products here. You can validate that the structure you have defined
    | is correct by running `php artisan billing:validate` command.
    |
    */

    'period' => Period::MONTHLY,

    /*
    |--------------------------------------------------------------------------
    | Billing Drivers
    |--------------------------------------------------------------------------
    |
    | If you are using the `config` driver, you may specify your plans and
    | products here. You can validate that the structure you have defined
    | is correct by running `php artisan billing:validate` command.
    |
    */
    'products' => [
        'forms_pro' => [
            'name' => 'Forms Pro',
            'group' => 'forms',
            'type' => 'null|recurring|once', 
            'price' => 1000, // Optional
            'period' => 'null|once|monthly|yearly', // Optional
            'price_id' => '', // Optional
            'prices' => [
                [
                    'period' => 'monthly',
                    'price' => 1000,
                    'price_id' => '',
                ],
                [
                    'period' => 'yearly', // 
                    'price' => 1000,
                    'price_id' => '', // REQUIRED
                ]
            ]
        ],
    ]
];