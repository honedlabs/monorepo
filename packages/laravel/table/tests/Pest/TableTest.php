<?php

declare(strict_types=1);

use Honed\Table\Table as HonedTable;
use Honed\Table\Tests\Fixtures\Table;
use Honed\Table\Tests\Stubs\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->test = Table::make();

    foreach (\range(1, 100) as $i) {
        product();
    }
});

it('builds', function () {
    expect($this->test->buildTable())
        ->toBe($this->test)
        ->getPaginator()->toBe('length-aware')
        ->getMeta()->toHaveCount(10)
        ->getCookie()->toBe('example-table');
});

it('can be modified', function () {
    $fn = fn (Builder $product) => $product->where('best_seller', true);

    expect($this->test)
        ->hasModifier()->toBeFalse()
        ->modifier($fn)->toBe($this->test)
        ->hasModifier()->toBeTrue();

    expect(Table::make($fn)->buildTable())
        ->hasModifier()->toBeTrue()
        ->getBuilder()->getQuery()->scoped(fn ($query) => $query
            ->wheres->scoped(fn ($wheres) => $wheres
                ->toBeArray()
                ->toHaveCount(1)
                ->{0}->toEqual([
                    'type' => 'Basic',
                    'column' => 'best_seller',
                    'operator' => '=',
                    'value' => true,
                    'boolean' => 'and',
                ])
            )->orders->scoped(fn ($orders) => $orders
                ->toBeArray()
                ->toHaveCount(1)
                ->{0}->toEqual([
                    'column' => 'products.name',
                    'direction' => 'desc',
                ])
            )
        );
});

// it('refines', function () {
//     expect($this->test->buildTable())
//         ->toBe($this->test)
//         ->getFilters()->toBe([]);
// });

// it('toggles', function () {
//     expect($this->test->buildTable())
//         ->toBe($this->test)
//         ->getColumns()->toBe([]);
// });

// it('actions', function () {
//     expect($this->test->buildTable())
//         ->toBe($this->test)
//         ->getActions()->toBe([]);
// });


