<?php

declare(strict_types=1);

use App\Models\User;
use App\Forms\UserForm;
use App\Models\Product;
use App\Forms\ProductForm;

afterEach(function () {
    Product::$formClass = null;
});

it('has table via attribute', function () {
    expect(User::form())
        ->toBeInstanceOf(UserForm::class);
});

it('has table via property', function () {
    expect(Product::form())
        ->toBeInstanceOf(ProductForm::class);
});

it('has table via guess', function () {
    Product::$formClass = ProductForm::class;

    expect(Product::form())
        ->toBeInstanceOf(ProductForm::class);
});