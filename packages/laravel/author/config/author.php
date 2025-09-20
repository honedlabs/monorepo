<?php

declare(strict_types=1);

return [

        /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    |
    | You can configure the model that will be used to store the authoring
    | information. By default, it will assume that you are using the default
    | Laravel User model. If you channge this, ensure you redefine the callback
    | on the `Author::using` method to match the new model's identifier.
    |
    */

    'model' => Illuminate\Foundation\Auth\User::class,

];
