<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Tests\Stubs\Product;

class MetaTest
{
    use Evaluable;
    use HasMeta;
}

beforeEach(function () {
    $this->test = new MetaTest;
});

it('sets', function () {
    expect($this->test->meta(['name' => 'test']))
        ->toBeInstanceOf(MetaTest::class)
        ->hasMeta()->toBeTrue();
});

it('gets', function () {
    expect($this->test)
        ->getMeta()->scoped(fn ($meta) => $meta
        ->toBeArray()
        ->toBeEmpty()
        )
        ->hasMeta()->toBeFalse();

    expect($this->test->meta(['name' => 'test']))
        ->getMeta()->toEqual(['name' => 'test'])
        ->hasMeta()->toBeTrue();
});

it('evaluates', function () {
    $product = product();
    expect($this->test->meta(fn (Product $product) => ['name' => $product->name]))
        ->getMeta(['product' => $product])->toEqual(['name' => $product->name])
        ->hasMeta()->toBeTrue();
});

it('evaluates model', function () {
    $product = product();
    expect($this->test->meta(fn (Product $product) => ['name' => $product->name]))
        ->getMeta($product)->toEqual(['name' => $product->name])
        ->hasMeta()->toBeTrue();
});
