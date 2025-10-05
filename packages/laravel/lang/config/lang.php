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

    'locales' => [
        'en',
    ],
];
