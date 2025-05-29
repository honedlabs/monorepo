<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware([Inertia\Middleware::class])
    ->group(function () {
        Route::get('/', fn () => inertia('Index')
            ->layout('AppLayout'));
    });
