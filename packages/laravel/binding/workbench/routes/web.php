<?php

declare(strict_types=1);

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/{user:show}', [UserController::class, 'show'])
    ->name('users.show');

Route::get('/user/{user:edit}', [UserController::class, 'edit'])
    ->name('users.edit');
