<?php

return [
    'endpoint' => '/actions',

    'paginator' => 'length-aware',

    'pagination' => [
        'options' => 10,
        'default' => 10,
    ],

    'toggle' => [
        'enabled' => false,
        'remember' => false,
        'duration' => 60 * 24 * 30 * 365,
    ],

    'keys' => [
        'pages' => 'page',
        'columns' => 'columns',
        'records' => 'rows',
    ]
];
