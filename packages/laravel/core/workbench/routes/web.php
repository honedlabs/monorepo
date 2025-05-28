<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Workbench\App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', fn () => User::all())
    ->name('users.index');

Route::get('/users/{user}', fn (User $user) => response()->json($user))
    ->name('users.show');
