<?php

declare(strict_types=1);

use Carbon\Carbon;
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

it('can use `like` operators', function () {
    $name = 'name';
    $value = 'test';

    $request = Request::create('/', 'GET', [$name => $value]);

    $filter = Filter::make($name)
        ->operator('like');

    expect($filter->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlySearch($this->builder->qualifyColumn($name));
});

it('can use dates', function () {
    $name = 'created_at';
    $value = Carbon::now();
    $operator = '>=';

    $request = Request::create('/', 'GET', [$name => $value->toDateTimeString()]);

    $filter = Filter::make($name)
        ->operator($operator)
        ->as('date');

    expect($filter->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->{0}->scoped(fn ($where) => $where
            ->{'type'}->toBe('Date')
            ->{'column'}->toBe($this->builder->qualifyColumn($name))
            ->{'operator'}->toBe($operator)
            ->{'value'}->toBe($value->toDateString())
            ->{'boolean'}->toBe('and')
        );
});

it('can use times', function () {
    $name = 'created_at';
    $value = Carbon::now();
    $operator = '>=';

    $request = Request::create('/', 'GET', [$name => $value->toDateTimeString()]);

    $filter = Filter::make($name)
        ->operator($operator)
        ->as('time');

    expect($filter->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->{0}->scoped(fn ($where) => $where
            ->{'type'}->toBe('Time')
            ->{'column'}->toBe($this->builder->qualifyColumn($name))
            ->{'operator'}->toBe($operator)
            ->{'value'}->toBe($value->toDateTimeString())
            ->{'boolean'}->toBe('and')
        );
});

it('accepts a callback', function () {
    $name = 'name';
    $value = 'test';

    $request = Request::create('/', 'GET', [$name => $value]);

    $filter = Filter::make($name)
        ->using(fn ($builder, $value) => $builder->where($name, 'like', $value.'%'));

    expect($filter->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($name, $value.'%', 'like');
});

it('can use `where` clause', function () {
    $name = 'quantity';
    $value = 10;

    $request = Request::create('/', 'GET', [$name => $value]);
    
    $filter = Filter::make($name)
        ->where($name, ':value');

    expect($filter->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toHaveOnlyWhere($name, $value);

    expect($filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($value);
});

it('can use `has` clause', function () {
    $name = 'details';
    $filter = Filter::make($name)
        ->whereHas('details');

    $request = Request::create('/', 'GET', [$name => 'false']);

    expect($filter->apply($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->{0}->scoped(fn ($where) => $where
            ->{'type'}->toBe('Exists')
        );    
});

// it('can use `whereHas`')

// it('can use `whereRelation`')