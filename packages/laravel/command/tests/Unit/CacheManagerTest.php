<?php

declare(strict_types=1);

use Honed\Command\Tests\Stubs\ProductCache;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    $this->cache = new ProductCache();
    $this->product = product();
});
it('has key', function () {
    expect($this->cache)
        ->key($this->product)->toBe(['products', $this->product->id])
        ->getKey($this->product)->toBe('products.1');
});

it('has value', function () {
    expect($this->cache)
        ->value($this->product)
        ->toBe($this->product->only('name'));
});

it('has duration', function () {
    expect($this->cache)
        ->duration()->toBeNull()
        ->getDuration()->toBe(0);
});

it('gets value', function () {
    expect(ProductCache::get($this->product))
        ->toBe($this->product->only('name'));
});

it('flushes value', function () {
    ProductCache::forget($this->product);

    expect(Cache::has($this->cache->getKey($this->product)))
        ->toBeFalse();
});
