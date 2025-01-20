<?php

declare(strict_types=1);

use Honed\Refining\Sorts\Sort;
use Honed\Refining\Tests\Stubs\Product;
use Illuminate\Support\Facades\Request;

beforeEach(function () {
    $this->builder = Product::query();
    $this->sort = Sort::make('name');
});

it('sorts by attribute', function () {
    $this->sort->value('name')->direction('asc')->apply($this->builder, request());

    expect($this->builder->getQuery()->orders)->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($order) => $order
            ->{'column'}->toBe($this->builder->qualifyColumn('name'))
            ->{'direction'}->toBe('asc')
        );
    
    expect($this->sort)
        ->isActive()->toBeTrue()
        ->getNextDirection()->toBe('-name')
        ->getDirection()->toBe('asc');
});

it('can enforce a singular direction', function () {
    expect($this->sort)
        ->isSingularDirection()->toBeFalse()
        ->desc()->toBe($this->sort)
        ->isSingularDirection()->toBeTrue();

    $this->sort->value('name')->direction(null)->apply($this->builder, request());

    expect($this->builder->getQuery()->orders)->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($order) => $order
            ->{'column'}->toBe($this->builder->qualifyColumn('name'))
            ->{'direction'}->toBe('desc')
        );
    
    expect($this->sort)
        ->isActive()->toBeTrue()
        ->getDirection()->toBe('desc')
        ->getNextDirection()->toBe('-name');
});

it('sets a fixed direction', function () {
    expect($this->sort)
        ->desc()->toBe($this->sort)
        ->isSingularDirection()->toBeTrue()
        ->asc()->toBe($this->sort)
        ->isSingularDirection()->toBeTrue();
});

it('has direction', function () {
    expect($this->sort)
        ->getAscendingValue()->toBe('name')
        ->getDescendingValue()->toBe('-name');
});

it('has array representation', function () {
    expect($this->sort->toArray())->toEqual([
        'name' => 'name',
        'label' => 'Name',
        'type' => 'sort',
        'meta' => [],
        'active' => false,
        'direction' => null,
        'next' => 'name',
    ]);
});

it('has next direction', function () {
    expect($this->sort)
        ->getNextDirection()->toBe('name')
        ->direction('asc')->getNextDirection()->toBe('-name')
        ->direction('desc')->getNextDirection()->toBeNull();
});
