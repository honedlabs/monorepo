<?php

use Honed\Core\Tests\Stubs\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{product}', fn (Product $product) => response()->json($product))
    ->name('products.show');

// Route::get('/{status}', fn (Status $status) => response()->json($status))
//     ->name('statuses.show');
