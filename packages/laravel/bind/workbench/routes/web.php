<?php

declare(strict_types=1);

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/user', UserController::class)
    ->only('show');

Route::get('/users/{user:edit}', [UserController::class, 'edit'])
    ->name('users.edit');

Route::get('/admin/{user:admin}', [AdminController::class, 'admin'])
    ->name('users.admin');

Route::get('/auth/{user:auth}', [AuthController::class, 'auth'])
    ->name('users.auth');
