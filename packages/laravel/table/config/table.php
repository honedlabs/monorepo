<?php

return [
    'endpoint' => '/actions',
    /*
    |--------------------------------------------------------------------------
    | Search configuration
    |--------------------------------------------------------------------------
    |
    | This option controls the default search configuration for a table when
    | not overriden on an inidiual table basis. The key is the query string
    | parameter to use for the search term. You can specify to use scout
    | searching for every table, this assumes you have Scout configured.
    */
    'search' => [
        'search' => 'q',
        'scout' => false,
        'columns' => [
            // 'name',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Toggle configuration
    |--------------------------------------------------------------------------
    */
    'toggle' => [
        'always' => false,
        'key' => 'cols',
        'duration' => 2592000,
        'cookie' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Sorting configuration
    |--------------------------------------------------------------------------
    */
    'sorting' => [
        'sort' => 'sort',
        'order' => 'order',
        'direction' => 'asc', // 'asc' or 'desc'
        // 'signed' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination configuration
    |--------------------------------------------------------------------------
    */
    'paginator' => [
        'key' => 'show',
        'name' => 'page',
        'count' => 10,
        'type' => 'simple', // 'simple' or 'full'
    ],

    /*
    |--------------------------------------------------------------------------
    | Chunk strategy
    |--------------------------------------------------------------------------
    */
    'chunk' => [
        'by_id' => true,
        'size' => 500,
    ],

    /*
    |--------------------------------------------------------------------------
    | Confirmation configuration
    |--------------------------------------------------------------------------
    */
    'confirm' => [
        'title' => 'Confirm',
        'description' => 'Are you sure you want to perform this action?',
        'cancel' => 'Cancel',
        'submit' => 'Confirm',
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallbacks
    |--------------------------------------------------------------------------
    | Control the fallback values for columns when the value is null.
    |
    */
    'fallbacks' => [
        'default' => null,
        'text' => '—',
        'numeric' => 0,
        'true' => 'Yes',
        'false' => 'No',
    ],
];
