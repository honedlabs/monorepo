<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasResource;
use Honed\Core\Contracts\Builds;
use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Tests\Stubs\Status;
use Illuminate\Database\Eloquent\Builder;

beforeEach(function () {
    $this->builder = Product::query();
    $this->test = new class
    {
        use HasResource;
    };
});

it('accesses', function () {
    expect($this->test)
        ->resource(Product::query())->toBe($this->test)
        ->getResource()->toBeInstanceOf(Builder::class)
        ->hasResource()->toBeTrue();
});

it('cannot retrieve without a builder', function () {
    $this->test->getResource();
})->throws(\RuntimeException::class);

it('has as builder', function () {
    expect($this->test->asBuilder(Product::query()))
        ->toBeInstanceOf(Builder::class);

    expect($this->test->asBuilder(Product::class))
        ->toBeInstanceOf(Builder::class);

    expect($this->test->asBuilder(product()))
        ->toBeInstanceOf(Builder::class);
});

it('cannot create without a valid builder', function () {
    $this->test->asBuilder(Status::cases());
})->throws(\InvalidArgumentException::class);
