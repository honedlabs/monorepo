<?php

declare(strict_types=1);

use Honed\Refine\Sorts\DescSort;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->builder = Product::query();

    $this->sort = DescSort::make('created_at')
        ->alias('oldest');
});

it('has desc sort', function () {
    expect($this->sort)
        ->enforcesDirection()->toBeTrue()
        ->getDirection()->toBe('desc')
        ->type()->toBe('sort:desc');
});

it('does not apply', function () {
    $builder = Product::query();

    expect($this->sort)
        ->handle($builder, 'invalid', 'asc')->toBeFalse();

    expect($builder->getQuery()->orders)
        ->toBeEmpty();
});

it('applies', function () {
    $builder = Product::query();

    expect($this->sort)
        ->handle($builder, 'oldest', 'desc')->toBeTrue();

    expect($builder->getQuery()->orders)
        ->toBeOnlyOrder('created_at', 'desc');
});
