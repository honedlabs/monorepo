<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Extend the validator
    |--------------------------------------------------------------------------
    |
    | You can toggle whether Laravel's validator should be extended to use the
    | custom validation rules provided by this package. Only set this to true
    | if you want to use string rules, such as 'required|scalar'. If you are
    | using solely validation attributes, this does not need to be enabled as
    | the underlying validation rule class is used for validation.
    |
    */

    'extends_validator' => false,

    /*
    |--------------------------------------------------------------------------
    | Phone country codes
    |--------------------------------------------------------------------------
    |
    | You can specify the country codes that should be used to validate phone
    | numbers by default, if no arguments are provided to the
    | `Honed\Data\Attributes\Validation\Phone` validation attribute. By default,
    | the INTERNATIONAL country code is used. See `propaganistas/laravel-phone`
    | for the list of supported country codes.
    |
    */

    'phone_country_codes' => ['INTERNATIONAL'],
];
