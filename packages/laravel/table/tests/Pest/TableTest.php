<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Honed\Table\Tests\Stubs\Status;
use Honed\Table\Table as HonedTable;
use Honed\Table\Tests\Stubs\Product;
use Honed\Table\Tests\Fixtures\Table;
use Illuminate\Database\Eloquent\Builder;

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

it('can toggle', function () {

});

it('can refine', function () {
    $request = Request::create('/', 'GET', [
        'name' => 'test',

        'price' => 100,
        'status' => \sprintf('%s,%s', Status::Available->value, Status::Unavailable->value),
        'only' => Status::ComingSoon->value,

        'favourite' => '1',

        'oldest' => '2000-01-01',
        'newest' => '2001-01-01',

        'missing' => 'test',

        Table::SortKey => '-price',

        Table::SearchKey => 'search term', // applied on name (col), description (property)
    ]);

    expect($this->test->for($request)->buildTable())
        ->getBuilder()->getQuery()->scoped(fn ($query) => $query
            ->wheres->scoped(fn ($wheres) => $wheres
                ->toBeArray()
                ->toHaveCount(9)
                ->toEqualCanonicalizing([
                    // Search done on name (column) and description (property)
                    [
                        'type' => 'raw',
                        'sql' => searchSql('name'),
                        'boolean' => 'and',
                    ],
                    [
                        'type' => 'raw',
                        'sql' => searchSql('description'),
                        'boolean' => 'or',
                    ],
                    // Name where filter 
                    [
                        'type' => 'raw',
                        'sql' => searchSql('name'),
                        'boolean' => 'and',
                    ],
                    // Price set filter
                    [
                        'type' => 'Basic',
                        'column' => qualifyProduct('price'),
                        'operator' => '<',
                        'value' => 100,
                        'boolean' => 'and',
                    ],
                    // Status set filter
                    [
                        'type' => 'In',
                        'column' => qualifyProduct('status'),
                        'values' => [Status::Available->value, Status::Unavailable->value],
                        'boolean' => 'and',
                    ],
                    // Only set filter
                    [
                        'type' => 'Basic',
                        'column' => qualifyProduct('status'),
                        'operator' => '=',
                        'value' => Status::ComingSoon->value,
                        'boolean' => 'and',
                    ],
                    // Favourite filter
                    [
                        'type' => 'Basic',
                        'column' => qualifyProduct('best_seller'),
                        'operator' => '=',
                        'value' => true,
                        'boolean' => 'and',
                    ],
                    // Oldest date filter
                    [
                        'type' => 'Date',
                        'column' => qualifyProduct('created_at'),
                        'operator' => '>',
                        'value' => '2000-01-01',
                        'boolean' => 'and',
                    ],
                    // Newest date filter
                    [
                        'type' => 'Date',
                        'column' => qualifyProduct('created_at'),
                        'operator' => '<',
                        'value' => '2001-01-01',
                        'boolean' => 'and',
                    ],
                ])
            )->orders->scoped(fn ($orders) => $orders
                ->toBeArray()
                ->toHaveCount(1)
                ->{0}->toEqual([
                    'column' => qualifyProduct('price'),
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


