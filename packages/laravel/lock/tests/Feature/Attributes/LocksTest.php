<?php

declare(strict_types=1);

use Honed\Lock\Attributes\Locks;
use Workbench\App\Models\Product;

it('has attribute', function () {
    $attribute = new Locks();

    expect($attribute)
        ->toBeInstanceOf(Locks::class);

    expect(Product::class)
        ->toHaveAttribute(Locks::class);
});
