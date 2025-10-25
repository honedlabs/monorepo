<?php

declare(strict_types=1);

use App\Http\Controllers\ExampleController;
use App\Http\Middleware\ExampleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(ExampleMiddleware::class)->group(function () {
    Route::get('/', fn () => inertia()->render('Home'))->name('home');
    Route::get('raw/{user}', [ExampleController::class, 'rawUser'])->name('raw.users.show');
    Route::get('raw/{user}/{product}', [ExampleController::class, 'rawproduct'])->name('raw.users.products.show');
    Route::get('{user}', [ExampleController::class, 'user'])->name('users.show');
    Route::get('{user}/{product}', [ExampleController::class, 'product'])->name('users.products.show');

    Route::get('different/{user}/{product}', [ExampleController::class, 'differentParameters'])->name('different.users.products.show');
});
