<?php

declare(strict_types=1);

use Workbench\App\Models\User;
use Workbench\App\Tables\UserTable;
use Workbench\App\Infolists\UserInfolist;
use Workbench\App\Models\Product;
use Workbench\App\Tables\ProductTable;

it('has table via attribute', function () {
    expect(User::table())
        ->toBeInstanceOf(UserTable::class);
});

it('has table via guess', function () {
    expect(Product::table())
        ->toBeInstanceOf(ProductTable::class);
});