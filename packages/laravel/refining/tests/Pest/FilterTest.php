<?php

declare(strict_types=1);

use Honed\Refining\Filters\Filter;
use Honed\Refining\Tests\Stubs\Product;
use Illuminate\Support\Facades\Request;

beforeEach(function () {
    $this->builder = Product::query();
    $this->param = 'name';
    $this->filter = Filter::make($this->param);
});

it('filters by exact value', function () {
    $request = Request::create('/', 'GET', [$this->param => 'test']);
    
    $this->filter->apply($this->builder, $request);

    expect($this->builder->getQuery()->wheres)->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($order) => $order
            ->{'column'}->toBe($this->builder->qualifyColumn('name'))
            ->{'value'}->toBe('test')
            ->{'operator'}->toBe('=')
            ->{'boolean'}->toBe('and')
        );
});

// it('filters using like operator', function () {
//     $request = request()->merge(['name' => 'test']);
    
//     $this->filter->like()->apply($this->builder, $request);

//     expect($this->builder->toSql())->toContain('LOWER("products"."name") LIKE ?')
//         ->and($this->builder->getBindings())->toBe(['%test%']);
// });

// it('filters using starts with', function () {
//     $request = request()->merge(['name' => 'test']);
    
//     $this->filter->startsWith()->apply($this->builder, $request);

//     expect($this->builder->toSql())->toContain('"products"."name" LIKE ?')
//         ->and($this->builder->getBindings())->toBe(['test%']);
// });

// it('filters using ends with', function () {
//     $request = request()->merge(['name' => 'test']);
    
//     $this->filter->endsWith()->apply($this->builder, $request);

//     expect($this->builder->toSql())->toContain('"products"."name" LIKE ?')
//         ->and($this->builder->getBindings())->toBe(['%test']);
// });

// it('filters using comparison operators', function () {
//     $request = request()->merge(['price' => 100]);
//     $filter = Filter::make('price');

//     $filter->gt()->apply($this->builder, $request);
//     expect($this->builder->toSql())->toContain('where "products"."price" > ?');

//     $this->builder = Product::query();
//     $filter->lt()->apply($this->builder, $request);
//     expect($this->builder->toSql())->toContain('where "products"."price" < ?');

//     $this->builder = Product::query();
//     $filter->not()->apply($this->builder, $request);
//     expect($this->builder->toSql())->toContain('where "products"."price" != ?');
// });

// it('has array representation', function () {
//     expect($this->filter->toArray())->toEqual([
//         'name' => 'name',
//         'label' => 'Name',
//         'type' => 'filter',
//         'meta' => [],
//         'active' => false,
//         'value' => null,
//     ]);
// });

// it('validates input before applying filter', function () {
//     $request = request()->merge(['name' => '']);
    
//     $this->filter
//         ->rules(['required', 'string'])
//         ->apply($this->builder, $request);

//     expect($this->builder->toSql())->not->toContain('where')
//         ->and($this->filter->isActive())->toBeFalse();
// });

// it('handles different modes and operators', function () {
//     expect($this->filter)
//         ->exact()->getMode()->toBe(Filter::Exact)
//         ->like()->getMode()->toBe(Filter::Like)
//         ->startsWith()->getMode()->toBe(Filter::StartsWith)
//         ->endsWith()->getMode()->toBe(Filter::EndsWith)
//         ->operator('=')->getOperator()->toBe('=')
//         ->not()->getOperator()->toBe(Filter::Not)
//         ->gt()->getOperator()->toBe(Filter::GreaterThan)
//         ->lt()->getOperator()->toBe(Filter::LessThan);
// });


