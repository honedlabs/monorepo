<?php

declare(strict_types=1);

use Honed\Refine\Filters\Filter;
use Honed\Refine\Tests\Stubs\Product;
use Illuminate\Support\Facades\Request;

beforeEach(function () {
    $this->builder = Product::query();
    $this->param = 'name';
});

it('uses `where` by default', function () {
    $request = Request::create('/', 'GET', [$this->param => 'test']);

    dd(
        Product::query()
            ->whereHas(
                'details', 
                fn ($query) => $query->where('quantity', '>=', 3)
            )->toSql()
    );

    dd(
        Product::query()
            ->whereRelation('details', 'quantity', '>=', 3)
            ->toSql()
    );

    dd(
        Product::query()
            ->where('name', 'test')
            ->toSql()
    );


    // $filter = Filter::make('name');

    // $filter = Filter

    // expect($this->builder->getQuery()->wheres)
    //     ->toBeArray()
    //     ->toHaveCount(1)
    //     ->{0}->scoped(fn ($order) => $order
    //         ->{'column'}->toBe($this->builder->qualifyColumn('name'))
    //         ->{'value'}->toBe('test')
    //         ->{'operator'}->toBe('=')
    //         ->{'boolean'}->toBe('and')
    //     );

    // expect($this->filter)
    //     ->isActive()->toBeTrue()
    //     ->getValue()->toBe('test');
});

// it
