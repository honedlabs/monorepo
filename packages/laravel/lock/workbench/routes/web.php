<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Workbench\App\Models\User;

Route::middleware([Inertia\Middleware::class, 'lock'])
    ->group(function () {
        Route::get('/', fn () => inertia('Home'));

        Route::get('/{user}', fn (User $user) => inertia('User/Show', [
            'user' => $user,
        ]))->name('user.show');
    });
