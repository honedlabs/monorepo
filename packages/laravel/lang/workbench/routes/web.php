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

Route::middleware(['localize', 'lang'])->get('/localize', function () {
    Lang::using('auth', 'login');

    return inertia('Welcome');
});

Route::localize(function () {
    Route::get('/users', function () {
        Lang::using('auth', 'login');

        return inertia('Welcome');
    })->name('users.index');

    Route::get('/users/{user}', function () {
        Lang::using('auth', 'login');

        return inertia('Welcome');
    })->name('users.show');

    Route::get('/injection', function (string $locale) {
        return $locale;
    });
});
