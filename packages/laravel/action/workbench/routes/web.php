<?php

use Illuminate\Support\Facades\Route;
use Workbench\App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::actions();

Route::get('/users', fn () => view('Welcome'))
    ->name('users.index');

Route::get('/users/{user}', fn (User $user) => view('Welcome'))
    ->name('users.show');