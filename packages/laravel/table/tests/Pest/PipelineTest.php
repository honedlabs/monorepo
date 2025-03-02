<?php

declare(strict_types=1);

use Honed\Table\Tests\Fixtures\Table as FixtureTable;
use Honed\Table\Tests\Stubs\Status;
use Illuminate\Http\Request;

it('builds', function () {

    foreach (\range(1, 100) as $i) {
        product();
    }
    $request = Request::create('/', 'GET', [
        'name' => 'test',

        'price' => 100,
        'status' => \sprintf('%s,%s', Status::Available->value, Status::Unavailable->value),
        'only' => Status::ComingSoon->value,

        'favourite' => '1',

        'oldest' => '2000-01-01',
        'newest' => '2001-01-01',

        'missing' => 'test',

        config('table.config.sorts') => '-price',

        config('table.config.searches') => 'search term', // applied on name (col), description (property)
    ]);

    expect(FixtureTable::make()
        ->request($request)
        ->build()
    )
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
                    'operator' => '<=',
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
                    'operator' => '>=',
                    'value' => '2000-01-01',
                    'boolean' => 'and',
                ],
                // Newest date filter
                [
                    'type' => 'Date',
                    'column' => qualifyProduct('created_at'),
                    'operator' => '<=',
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
        )->toArray()->scoped(fn ($array) => $array
            ->{'config'}->toEqual([
                'delimiter' => config('table.config.delimiter'),
                'record' => 'id',
                'records' => config('table.config.records'),
                'sorts' => config('table.config.sorts'),
                'searches' => config('table.config.searches'),
                'columns' => FixtureTable::ColumnsKey,
                'pages' => FixtureTable::PagesKey,
                'endpoint' => config('table.endpoint'),
                'search' => 'search term'
            ])->{'actions'}->scoped(fn ($actions) => $actions
                ->toHaveKeys([ 'hasInline', 'bulk', 'page'])
                ->{'hasInline'}->toBeTrue()
                ->{'bulk'}->toHaveCount(1)
                ->{'page'}->toHaveCount(2)
            )->{'toggleable'}->toBe(FixtureTable::Toggle)
            ->{'sorts'}->toHaveCount(4)
            ->{'filters'}->toHaveCount(7)
            ->{'columns'}->toHaveCount(9)
        );
});