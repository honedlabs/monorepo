<?php

declare(strict_types=1);

use Honed\Billing\Payment;
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
            'table' => 'products',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | If you are using the `config` driver, you may specify your plans and
    | products here. You can validate that the structure you have defined
    | is correct by running `php artisan billing:validate` command.
    |
    */

    'type' => Payment::RECURRING,

    'period' => Period::MONTHLY,

    /*
    |--------------------------------------------------------------------------
    | Billing Products
    |--------------------------------------------------------------------------
    |
    | If you are using the `config` driver, you may specify your plans and
    | products here. You can validate that the structure you have defined
    | is correct by running the `php artisan billing:validate` command.
    |
    */

    'products' => [
        [
            'id' => 'monthly',
            'name' => 'Monthly',
            'group' => 'default',
            'price' => 1000,
            'price_id' => 'price_monthly',
        ],
        [
            'id' => 'yearly',
            'name' => 'Yearly',
            'group' => 'default',
            'price' => 10000,
            'period' => Period::YEARLY,
            'price_id' => 'price_yearly',
        ],
        [
            'id' => 'lifetime',
            'name' => 'Lifetime',
            'price' => 100000,
            'type' => Payment::ONCE,
            'price_id' => 'price_lifetime',
        ],
    ],
];
