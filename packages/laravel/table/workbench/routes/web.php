<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::actions();

Route::tableViews();

Route::get('/', fn () => view('welcome'))
    ->name('home');

Route::get('/products', fn () => view('welcome'))
    ->name('products.index');

Route::get('/products/{product}', fn () => view('welcome'))
    ->name('products.show');

Route::get('/products/create', fn () => view('welcome'))
    ->name('products.create');
