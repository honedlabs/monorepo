<?php

declare(strict_types=1);

use Honed\Command\Tests\Stubs\Product;
use Honed\Command\Tests\Stubs\ProductCache;

it('has a cache manager', function () {
    expect(Product::cache())
        ->toBeInstanceOf(ProductCache::class);
});

it('caches value', function () {
    $product = product();

    expect($product)
        ->cached()->toBe(['name' => $product->name])
        ->forgetCached()->toBeNull();
});
