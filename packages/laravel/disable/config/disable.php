<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Boolean
    |--------------------------------------------------------------------------
    |
    | You can configure whether, by default, the disabled state of your models
    | should be stored via an "is_disabled" boolean field. You can configure
    | the name of the column on a per-model basis by modifying the DISABLED
    | constant.
    |
    */

    'boolean' => true,

    /*
    |--------------------------------------------------------------------------
    | Timestamp
    |--------------------------------------------------------------------------
    |
    | You can configure whether, by default, the disabled state of your models
    | should be stored via a "disabled_at" timestamp field. You can configure
    | the name of the column on a per-model basis by modifying the DISABLED_AT
    | constant.
    |
    */

    'timestamp' => true,

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    |
    | You can configure whether, by default, the disabled state of your models
    | should be stored via a "disabled_by" user field. You can configure
    | the name of the column on a per-model basis by modifying the DISABLED_BY
    | constant.
    |
    */

    'user' => true,
];
