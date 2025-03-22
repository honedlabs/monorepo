<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasBuilderInstance;
use Honed\Core\Contracts\Builds;
use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Tests\Stubs\Status;
use Illuminate\Database\Eloquent\Builder;

beforeEach(function () {
    $this->builder = Product::query();
    $this->test = new class
    {
        use HasBuilderInstance;
    };
});

it('accesses', function () {
    expect($this->test)
        ->hasBuilder()->toBeFalse()
        ->builder(Product::query())->toBe($this->test)
        ->getBuilder()->toBeInstanceOf(Builder::class)
        ->hasBuilder()->toBeTrue();
});

it('accesses via contract', function () {
    $test = new class implements Builds {
        use HasBuilderInstance;

        public function for()
        {
            return Product::query();
        }
    };

    expect($test->getBuilder())->toBeInstanceOf(Builder::class);
});

it('cannot retrieve without a builder', function () {
    $this->test->getBuilder();
})->throws(\RuntimeException::class);

it('creates', function () {
    expect($this->test->createBuilder(Product::query()))
        ->toBeInstanceOf(Builder::class);

    expect($this->test->createBuilder(Product::class))
        ->toBeInstanceOf(Builder::class);

    expect($this->test->createBuilder(product()))
        ->toBeInstanceOf(Builder::class);
});

it('cannot create without a valid builder', function () {
    $this->test->createBuilder(Status::cases());
})->throws(\InvalidArgumentException::class);
