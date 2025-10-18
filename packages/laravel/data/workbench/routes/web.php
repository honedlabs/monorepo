<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocaleUserController;
use App\Http\Controllers\ProductUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('user', UserController::class);

Route::resource('locales.user', LocaleUserController::class);

Route::resource('products.user', ProductUserController::class);
