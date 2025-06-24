<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Workbench\App\Enums\Status;
use Workbench\App\Models\Product;
use Workbench\App\Tables\ProductTable;

beforeEach(function () {
    Product::factory()->count(100)->create();

    $this->request = Request::create('/', 'GET', [
        'name' => 'test',

        'price' => 100,
        'status' => \sprintf('%s,%s', Status::Available->value, Status::Unavailable->value),
        'only' => Status::ComingSoon->value,

        'favourite' => '1',

        'oldest' => '2000-01-01',
        'newest' => '2001-01-01',

        'missing' => 'test',

        config('table.sort_key') => '-price',
        config('table.search_key') => 'search+term',
        config('table.column_key') => 'id,name,price,status,best_seller,created_at',
        config('table.record_key') => 25,
    ]);
})->skip();

it('builds class', function () {

    $request = Request::create('/', 'GET', [
        'name' => 'test',

        'price' => 100,
        'status' => \sprintf('%s,%s', Status::Available->value, Status::Unavailable->value),
        'only' => Status::ComingSoon->value,

        'favourite' => '1',

        'oldest' => '2000-01-01',
        'newest' => '2001-01-01',

        'missing' => 'test',

        config('table.sort_key') => '-price',
        config('table.search_key') => 'search+term',
        config('table.column_key') => 'id,name,price,status,best_seller,created_at',
        config('table.record_key') => 25,
    ]);

    expect(ProductTable::make($request)
        ->request($request)
        ->build()
    )->getResource()->getQuery()->scoped(fn ($query) => $query
        ->wheres->scoped(fn ($wheres) => $wheres
        ->toBeArray()
        ->toHaveCount(9)
        ->toEqualCanonicalizing([
            // Search done on name (column) and description (property)
            [
                'type' => 'raw',
                'boolean' => 'or', // <- this fails
            ],
            [
                'type' => 'raw',
                'boolean' => 'and',
            ],
            // Name where filter
            [
                'type' => 'raw',
                'sql' => 'name',
                'boolean' => 'and',
            ],
            // Price set filter
            [
                'type' => 'Basic',
                'column' => 'price',
                'operator' => '<=',
                'value' => 100,
                'boolean' => 'and',
            ],
            // Status set filter
            [
                'type' => 'In',
                'column' => 'status',
                'values' => [Status::Available->value, Status::Unavailable->value],
                'boolean' => 'and',
            ],
            // Only set filter
            [
                'type' => 'In',
                'column' => 'status',
                'values' => [Status::ComingSoon->value],
                'boolean' => 'and',
            ],
            // Favourite filter
            [
                'type' => 'Basic',
                'column' => 'best_seller',
                'operator' => '=',
                'value' => true,
                'boolean' => 'and',
            ],
            // Oldest date filter
            [
                'type' => 'Date',
                'column' => 'created_at',
                'operator' => '>=',
                'value' => '2000-01-01',
                'boolean' => 'and',
            ],
            // Newest date filter
            [
                'type' => 'Date',
                'column' => 'created_at',
                'operator' => '<=',
                'value' => '2001-01-01',
                'boolean' => 'and',
            ],
        ])
        )->orders
        ->scoped(fn ($orders) => $orders
            ->toBeArray()
            ->toHaveCount(1)
            ->{0}->toEqual([
                'column' => 'price',
                'direction' => 'desc',
            ])
        )
    );
});
