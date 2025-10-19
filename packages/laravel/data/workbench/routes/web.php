<?php

declare(strict_types=1);

use App\Http\Controllers\LocaleUserController;
use App\Http\Controllers\ProductUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', UserController::class);

Route::resource('locales.users', LocaleUserController::class);

Route::resource('products.users', ProductUserController::class);
