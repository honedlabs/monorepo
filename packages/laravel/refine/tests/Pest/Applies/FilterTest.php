<?php

declare(strict_types=1);

use Carbon\Carbon;
use Honed\Refine\Filter;
use Honed\Refine\Tests\Stubs\Product;
use Illuminate\Support\Facades\Request;

beforeEach(function () {
    $this->builder = Product::query();
    $this->name = 'name';
    $this->alias = 'alias';
    $this->value = 'value';
    $this->filter = Filter::make($this->name);
});

it('does not apply', function () {
    $request = Request::create('/', 'GET', ['none' => $this->value]);
    
    expect($this->filter->refine($this->builder, $request))
        ->toBeFalse();
    
    expect($this->builder->getQuery()->wheres)
        ->toBeEmpty();
    
    expect($this->filter)
        ->isActive()->toBeFalse()
        ->getValue()->toBeNull();
});

it('applies', function () {
    $request = Request::create('/', 'GET', [$this->name => $this->value]);

    expect($this->filter->refine($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($this->builder->qualifyColumn($this->name), $this->value);

    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($this->value);
});

it('does not apply with alias', function () {
    $request = Request::create('/', 'GET', [$this->name => $this->value]);

    expect($this->filter->alias($this->alias))
        ->refine($this->builder, $request)->toBeFalse();
        
    expect($this->builder->getQuery()->wheres)
        ->toBeEmpty();
    
    expect($this->filter)
        ->isActive()->toBeFalse()
        ->getValue()->toBeNull();
});

it('applies with alias', function () {
    $request = Request::create('/', 'GET', [$this->alias => $this->value]);

    expect($this->filter->alias($this->alias))
        ->refine($this->builder, $request)->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($this->name, $this->value);

    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($this->value);
});

it('does not apply with scope', function () {
    $scope = 'scope';

    $request = Request::create('/', 'GET', [$this->name => $this->value]);

    expect($this->filter->scope($scope))
        ->refine($this->builder, $request)->toBeFalse();

    expect($this->builder->getQuery()->wheres)
        ->toBeEmpty();
    
    expect($this->filter)
        ->isActive()->toBeFalse()
        ->getValue()->toBeNull();
});

it('applies with scope', function () {
    $this->filter->scope('scope');

    $request = Request::create('/', 'GET', [
        $this->filter->formatScope($this->name) => $this->value
    ]);

    expect($this->filter)
        ->refine($this->builder, $request)->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($this->builder->qualifyColumn($this->name), $this->value);

    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($this->value);
});

it('applies with different operator', function () {
    $operator = '>';

    $request = Request::create('/', 'GET', [$this->name => $this->value]);

    expect($this->filter->operator($operator))
        ->refine($this->builder, $request)->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($this->name, $this->value, $operator);

    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($this->value);
});

it('applies with `like` operators', function () {
    $request = Request::create('/', 'GET', [$this->name => $this->value]);

    expect($this->filter->operator('like'))
        ->refine($this->builder, $request)->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlySearch($this->name);

    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($this->value);
});

it('applies with date', function () {
    $value = Carbon::now();

    $request = Request::create('/', 'GET', [
        $this->name => $value->toIso8601String()
    ]);

    expect($this->filter->date())
        ->refine($this->builder, $request)->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->{0}->scoped(fn ($where) => $where
            ->{'type'}->toBe('Date')
            ->{'column'}->toBe($this->name)
            ->{'operator'}->toBe('=')
            ->{'value'}->toBe($value->toDateString())
            ->{'boolean'}->toBe('and')
        );

    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBeInstanceOf(Carbon::class);
});

it('applies with datetime', function () {
    $value = Carbon::now();

    $request = Request::create('/', 'GET', [
        $this->name => $value->toIso8601String()
    ]);

    expect($this->filter->datetime())
        ->refine($this->builder, $request)->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->{0}->scoped(fn ($where) => $where
            ->{'type'}->toBe('Basic')
            ->{'column'}->toBe($this->name)
            ->{'operator'}->toBe('=')
            ->{'value'}->toBeInstanceOf(Carbon::class)
            ->{'boolean'}->toBe('and')
        );

    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBeInstanceOf(Carbon::class);
});

it('applies with time', function () {
    $value = Carbon::now();

    $request = Request::create('/', 'GET', [
        $this->name => $value->toIso8601String()
    ]);

    expect($this->filter->time())
        ->refine($this->builder, $request)->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->{0}->scoped(fn ($where) => $where
            ->{'type'}->toBe('Time')
            ->{'column'}->toBe($this->name)
            ->{'operator'}->toBe('=')
            ->{'value'}->toBe($value->toTimeString())
            ->{'boolean'}->toBe('and')
        );

    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBeInstanceOf(Carbon::class);
});

it('applies with query', function () {
    $request = Request::create('/', 'GET', [$this->name => $this->value]);

    $fn = fn ($builder, $value) => $builder->where($this->name, 'like', $value.'%');

    expect($this->filter->query($fn))
        ->refine($this->builder, $request)->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($this->name, $this->value.'%', 'like');

    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($this->value);
});

it('applies lax', function () {
    $builder = Product::query();

    $filter = Filter::make('status')
        ->options(['active' => 'Active', 'inactive' => 'Inactive'])
        ->lax();

    $value = 'indeterminate';

    $request = Request::create('/', 'GET', ['status' => $value]);

    expect($filter->refine($builder, $request))
        ->toBeTrue();

    expect($builder->getQuery()->wheres)
        ->toBeOnlyWhere($builder->qualifyColumn('status'), $value);

    expect($filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($value)
        ->getOptions()->each(fn ($option) => $option->isActive()->toBeFalse());
});

it('applies strict', function () {
    $builder = Product::query();

    $filter = Filter::make('status')
        ->options(['active' => 'Active', 'inactive' => 'Inactive'])
        ->strict();

    $value = 'indeterminate';

    $request = Request::create('/', 'GET', ['status' => $value]);

    expect($filter->refine($builder, $request))
        ->toBeFalse();

    expect($builder->getQuery()->wheres)
        ->toBeEmpty();

    expect($filter)
        ->isActive()->toBeFalse()
        ->getValue()->toBeNull() // Transform means invalid values are discarded
        ->getOptions()->each(fn ($option) => $option->isActive()->toBeFalse())
        ->optionsToArray()->toEqual([
            [
                'value' => 'active',
                'label' => 'Active',
                'active' => false,
            ],
            [
                'value' => 'inactive',
                'label' => 'Inactive',
                'active' => false,
            ],
        ]);
});

it('applies multiple', function () {
    $builder = Product::query();

    $filter = Filter::make('status')
        ->options(['active' => 'Active', 'inactive' => 'Inactive'])
        ->multiple();

    $value = ['active', 'inactive'];
    $valueString = \implode(',', $value);

    $request = Request::create('/', 'GET', ['status' => $valueString]);

    expect($filter->refine($builder, $request))
        ->toBeTrue();

    expect($builder->getQuery()->wheres)
        ->toBeOnlyWhereIn($builder->qualifyColumn('status'), $value);

    expect($filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($value)
        ->getOptions()->each(fn ($option) => $option->isActive()->toBeTrue())
        ->optionsToArray()->toEqual([
            [
                'value' => 'active',
                'label' => 'Active',
                'active' => true,
            ],
            [
                'value' => 'inactive',
                'label' => 'Inactive',
                'active' => true,
            ],
        ]);
});

it('applies with unqualified column', function () {
    $request = Request::create('/', 'GET', [$this->name => 'value']);

    expect($this->filter->unqualify()->refine($this->builder, $request))
        ->toBeTrue();

    expect($this->builder->getQuery()->wheres)
        ->toBeOnlyWhere($this->name, 'value');

    expect($this->filter)
        ->isQualified()->toBeTrue()
        ->isActive()->toBeTrue();
});
