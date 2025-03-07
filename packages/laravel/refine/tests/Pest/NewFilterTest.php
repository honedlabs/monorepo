<?php

declare(strict_types=1);

use Honed\Refine\Filters\Filter;
use Honed\Refine\Tests\Stubs\Product;
use Illuminate\Support\Facades\Request;

beforeEach(function () {
    $this->builder = Product::query();
});

it('uses alias over name', function () {
    $name = 'name';
    $alias = 'alias';
    $value = 'test';

    $request = Request::create('/', 'GET', [$alias => $value]);

    $filter = Filter::make($name)->alias($alias);

    expect($filter->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($this->builder->qualifyColumn($name), $value);

    expect($filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($value);
});

it('scopes the filter query parameter', function () {
    $name = 'name';
    $alias = 'alias';
    $scope = 'scope';
    $value = 'value';

    $filter = Filter::make($name)
        ->alias($alias)
        ->scope($scope);

    $key = $filter->formatScope($alias);
    $request = Request::create('/', 'GET', [$key => $value]);

    expect($filter->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($this->builder->qualifyColumn($name), $value);

    expect($filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($value);
});

it('requires the parameter name to be present', function () {
    $name = 'name';
    $alias = 'alias';
    $value = 'test';

    $request = Request::create('/', 'GET', [$name => $value]);

    $filter = Filter::make($name)->alias($alias);

    expect($filter->apply($this->builder, $request))
        ->toBeFalse();

    expect($this->builder->getQuery()->wheres)
        ->toBeEmpty();

    expect($filter)
        ->isActive()->toBeFalse()
        ->getValue()->toBeNull();
});


it('uses `where` by default', function () {
    $name = 'name';
    $value = 'test';

    $request = Request::create('/', 'GET', [$name => $value]);

    $filter = Filter::make($name);

    expect($filter->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($this->builder->qualifyColumn($name), $value);

    expect($filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($value);
});

it('can change the `where` operator', function () {
    $name = 'price';
    $value = 5;
    $operator = '>';

    $request = Request::create('/', 'GET', [$name => $value]);

    $filter = Filter::make($name)
        ->operator($operator);

    expect($filter->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($this->builder->qualifyColumn($name), $value, $operator);

    expect($filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($value);
});