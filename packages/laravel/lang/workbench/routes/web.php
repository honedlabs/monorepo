<?php

declare(strict_types=1);

use Honed\Lang\Facades\Lang;
use Illuminate\Support\Facades\Route;

Route::middleware('lang')->get('/', function () {
    Lang::use('auth')->only('auth.login');

    return inertia('Welcome');
});

Route::middleware('lang:greetings')->get('/greetings', function () {
    Lang::use('auth')->only('auth.login', 'greetings.greeting');

    return inertia('Welcome');
});

Route::middleware('lang:greetings')->get('/empty', function () {
    Lang::only('auth.login');

    return inertia('Welcome');
});
