<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Source File(s)
    |--------------------------------------------------------------------------
    |
    | Provide the location where any global crumbs are defined. These can
    | be used to define crumb trails which apply to multiple routes.
    |
    */
    'files' => base_path('routes/crumbs.php'),

    /*
    |--------------------------------------------------------------------------
    | Property Name
    |--------------------------------------------------------------------------
    |
    | The name of the property when sharing crumbs to your frontend. Ensure
    | this does not conflict with any other property names in your frontend.
    |
    */
    'property' => 'crumbs',
];
