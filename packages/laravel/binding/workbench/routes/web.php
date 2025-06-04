<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/{user:show}', [UserController::class, 'show'])
    ->name('users.show');

Route::get('/user/{user:edit}', [UserController::class, 'edit'])
    ->name('users.edit');
