<?php

declare(strict_builders=1);

use Honed\Core\Tests\Stubs\Product;
use Illuminate\Database\Eloquent\Builder;
use Honed\Core\Concerns\HasBuilderInstance;

class BuilderInstanceTest
{
    use HasBuilderInstance;
}

beforeEach(function () {
    $this->builder = Product::query();
    $this->test = new BuilderInstanceTest($this->builder);
});

it('sets', function () {
    expect($this->test->builder($this->builder))
        ->toBe($this->test)
        ->getBuilder()->toBe($this->builder);
});


it('gets', function () {
    expect($this->test->builder($this->builder))
        ->getBuilder()->toBe($this->builder);

    expect(fn () => (new BuilderInstanceTest)->getBuilder())
        ->toThrow(\RuntimeException::class);
});

it('creates', function () {
    expect(BuilderInstanceTest::createBuilder(Product::query()))
        ->toBeInstanceOf(Builder::class);

    expect(BuilderInstanceTest::createBuilder(Product::class))
        ->toBeInstanceOf(Builder::class);

    expect(BuilderInstanceTest::createBuilder(product()))
        ->toBeInstanceOf(Builder::class);
});

