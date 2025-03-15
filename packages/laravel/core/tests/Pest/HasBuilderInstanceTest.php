<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasBuilderInstance;
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

it('sets', function () {
    expect($this->test)
        ->builder($this->builder)->toBe($this->test)
        ->getBuilder()->toBe($this->builder);
});

it('gets', function () {
    expect($this->test)
        ->hasBuilder()->toBeFalse()
        ->builder($this->builder)->toBe($this->test)
        ->hasBuilder()->toBeTrue()
        ->getBuilder()->toBe($this->builder);
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
