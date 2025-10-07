<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Language path
    |--------------------------------------------------------------------------
    |
    | The path of base the directory where your language files are stored.
    | By default, it will use Laravel's built-in lang_path() helper, which
    | points to the "resources/lang" directory.
    |
    | You can override this to point to a custom location if needed.
    | Ensure the lang files are using PHP and not JSON syntax.
    |
    */

    'lang_path' => lang_path(),

    /*
    |--------------------------------------------------------------------------
    | Session
    |--------------------------------------------------------------------------
    |
    | Whether to store the locale in the session. When true, the locale will be
    | persisted to the session when setting. To use the session driver, ensure
    | the `localize` middleware is registered to set it to the app locale.
    |
    */

    'session' => true,

    /*
    |--------------------------------------------------------------------------
    | Locales
    |--------------------------------------------------------------------------
    |
    | You must specify the locales that are supported by your application.
    | Locales which are not specified here will be ignored when setting the
    | locale using the Lang facade.
    |
    */
    'locales' => [
        'en',
    ],
];
