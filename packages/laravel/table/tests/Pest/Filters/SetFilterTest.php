<?php

use Honed\Core\Options\Option;
use Honed\Table\Filters\Enums\Clause;
use Honed\Table\Filters\Enums\Operator;
use Honed\Table\Filters\SetFilter;
use Honed\Table\Tests\Stubs\Product;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

beforeEach(function () {
    $this->name = 'name';
    $this->value = 'test';
    $this->filter = SetFilter::make($this->name);
    $this->builder = Product::query();
    Request::swap(Request::create('/', HttpFoundationRequest::METHOD_GET, [$this->name => $this->value]));
});

it('has defaults', function () {
    expect($this->filter)
        ->getType()->toBe('filter:set')
        ->getClause()->toBe(Clause::Is)
        ->getOperator()->toBe(Operator::Equal)
        ->hasOptions()->toBeFalse()
        ->isMultiple()->toBeFalse()
        ->isStrict()->toBeTrue();
});

it('can be applied', function () {
    $this->filter->apply($this->builder);

    expect($this->builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->{0}->toEqual([
            'type' => 'Basic',
            'column' => $this->name,
            'operator' => Operator::Equal->value,
            'value' => $this->value,
            'boolean' => 'and',
        ]);

    expect($this->filter)
        ->isActive()->toBeTrue()
        ->getValue()->toBe($this->value);
});

it('does not apply when parameter name is not present', function () {
    $request = Request::create('/', HttpFoundationRequest::METHOD_GET, ['fake' => $this->value]);

    $this->filter->apply($this->builder, $request);

    expect($this->builder->getQuery()->wheres)
        ->toBeEmpty();

    expect($this->filter)
        ->isActive()->toBeFalse()
        ->getValue()->toBeNull();
});

it('applies a `whereIn` if the filter is multiple', function () {
    Request::swap(Request::create('/', 'GET', ['name' => 'test,test2']));
    $this->filter->setMultiple(true);
    $this->filter->apply($this->builder);

    expect($this->builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->toEqual([
            [
                'type' => 'In',
                'column' => 'name',
                'values' => ['test', 'test2'],
                'boolean' => 'and',
            ],
        ]);
});

it('converts query parameters', function () {
    expect($this->filter->getValueFromRequest())->toBe('test');
    Request::swap(Request::create('/', 'GET', ['name' => 'test,test2']));
    $this->filter->setMultiple(true);
    expect($this->filter->getValueFromRequest())->toEqual(['test', 'test2']);
});

it('can use options', function () {
    $this->filter->setOptions([
        Option::make('test'),
        Option::make('test2'),
    ]);
    expect($this->filter->getOptions())->toHaveCount(2);

    $this->filter->apply($this->builder);
    expect($this->builder->getQuery()->wheres)
        ->toHaveCount(1)
        ->toEqual([
            [
                'type' => 'Basic',
                'column' => 'name',
                'operator' => '=',
                'value' => 'test',
                'boolean' => 'and',
            ],
        ]);

    expect(collect($this->filter->getOptions())->first(fn ($option) => $option->isActive()))->not->toBeNull();
});

it('can be strict about the values', function () {
    $this->filter->setStrict(true);
    $this->filter->setOptions([
        Option::make('test'),
        Option::make('test2'),
    ]);
    expect($this->filter->isFiltering('test3'))->toBeFalse();
    expect($this->filter->isFiltering('test'))->toBeTrue();

    $this->filter->setStrict(false);
    expect($this->filter->isFiltering('test3'))->toBeTrue();
});

it('has array representation', function () {
    expect($this->filter->toArray())->toEqual([
        'name' => 'name',
        'label' => 'Name',
        'type' => 'filter:set',
        'active' => false,
        'value' => null,
        'meta' => [],
        'options' => [],
    ]);
});
