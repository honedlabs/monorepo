<?php

declare(strict_types=1);

use Honed\Refine\Sort;
use Honed\Refine\Tests\Stubs\Product;

beforeEach(function () {
    $this->builder = Product::query();
});

it('does not apply', function () {
    $name = 'name';

    $sort = Sort::make($name);

    expect($sort->refine($this->builder, ['other', 'asc']))
        ->toBeFalse();

    expect($this->builder->getQuery()->orders)
        ->toBeEmpty();

    expect($sort)
        ->isActive()->toBeFalse()
        ->getDirection()->toBeNull()
        ->getNextDirection()->toBe($name);
});

it('applies alias', function () {
    $name = 'name';
    $alias = 'alphabetical';
    
    $sort = Sort::make($name)->alias($alias);
    
    // Should not apply

    expect($sort->refine($this->builder, [$name, 'asc']))
        ->toBeFalse();

    expect($this->builder->getQuery()->orders)
        ->toBeEmpty();

    expect($sort)
        ->isActive()->toBeFalse()
        ->getDirection()->toBeNull()
        ->getNextDirection()->toBe($alias);

    // Should apply

    expect($sort->refine($this->builder, [$alias, 'asc']))
        ->toBeTrue();

    expect($this->builder->getQuery()->orders)
        ->toBeOnlyOrder($this->builder->qualifyColumn($name), 'asc');

    expect($sort)
        ->isActive()->toBeTrue()
        ->getDirection()->toBe('asc')
        ->getNextDirection()->toBe('-'.$alias);
});

it('applies fixed direction', function () {
    $name = 'name';
    
    $sort = Sort::make($name)
        ->desc();

    $descending = $name.'_desc';

    expect($sort->refine($this->builder, [$descending, 'desc']))
        ->toBeTrue();

    expect($this->builder->getQuery()->orders)
        ->toBeOnlyOrder($this->builder->qualifyColumn($name), 'desc');

    expect($sort)
        ->isFixed()->toBeTrue()
        ->isActive()->toBeTrue()
        ->getDirection()->toBe('desc')
        ->getNextDirection()->toBe($descending);
});

it('applies inverted direction', function () {
    $name = 'name';
    
    $sort = Sort::make($name)->invert();

    expect($sort->refine($this->builder, [$name, 'desc']))
        ->toBeTrue();

    expect($this->builder->getQuery()->orders)
        ->toBeOnlyOrder($this->builder->qualifyColumn($name), 'desc');

    expect($sort)
        ->isInverted()->toBeTrue()
        ->isActive()->toBeTrue()
        ->getDirection()->toBe('desc')
        ->getNextDirection()->toBe($name);
});

it('applies query', function () {
    $name = 'name';

    $sort = Sort::make($name)
        ->query(fn ($builder, $direction) => $builder->orderBy('created_at', $direction));

    expect($sort->refine($this->builder, [$name, 'desc']))
        ->toBeTrue();

    expect($this->builder->getQuery()->orders)
        ->toBeOnlyOrder('created_at', 'desc');
    
    expect($sort)
        ->isActive()->toBeTrue();
});