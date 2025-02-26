<?php

declare(strict_types=1);

return [
    'disk' => 's3',

    'size' => [
        'max' => null,
        'min' => null,
        'unit' => 'bytes',
    ],

    'types' => [

    ],

    'expires' => '+2 minutes',

    'bucket' => null,

    'acl' => 'public-read',
];
