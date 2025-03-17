<?php

declare(strict_types=1);

use Honed\Table\Table;
use Honed\Table\Columns\Column;
use Illuminate\Support\Facades\Request;
use Honed\Table\Tests\Fixtures\Table as FixtureTable;
use Honed\Table\Tests\Stubs\Product;

beforeEach(function () {
    $this->table = FixtureTable::make();
});

it('has a sorts key', function () {
    $sortsKey = 's';

    // Class-based
    expect($this->table)
        ->getSortsKey()->toBe(config('table.sorts_key'))
        ->sortsKey($sortsKey)->toBe($this->table)
        ->getSortsKey()->toBe($sortsKey);

    // Anonymous
    expect(Table::make())
        ->getSortsKey()->toBe(config('table.sorts_key'))
        ->sortsKey($sortsKey)->toBeInstanceOf(Table::class)
        ->getSortsKey()->toBe($sortsKey);
});

it('has a searches key', function () {
    $searchesKey = 's';

    // Class-based
    expect($this->table)
        ->getSearchesKey()->toBe(config('table.searches_key'))
        ->searchesKey($searchesKey)->toBe($this->table)
        ->getSearchesKey()->toBe($searchesKey);

    // Anonymous
    expect(Table::make())
        ->getSearchesKey()->toBe(config('table.searches_key'))
        ->searchesKey($searchesKey)->toBeInstanceOf(Table::class)
        ->getSearchesKey()->toBe($searchesKey);
});

it('can match', function () {
    $matching = true;

    // Class-based
    expect($this->table)
        ->isMatching()->toBe(config('table.match'));

    expect($this->table->match($matching))
        ->toBe($this->table)
        ->isMatching()->toBe($matching);

    // Anonymous
    expect(Table::make())
        ->isMatching()->toBe(config('table.match'));

    expect(Table::make()->match($matching))
        ->toBeInstanceOf(Table::class)
        ->isMatching()->toBe($matching);
});

it('has a delimiter', function () {
    $delimiter = '|';

    // Class-based
    expect($this->table)
        ->getDelimiter()->toBe(config('table.delimiter'))
        ->delimiter($delimiter)->toBe($this->table)
        ->getDelimiter()->toBe($delimiter);

    // Anonymous
    expect(Table::make())
        ->getDelimiter()->toBe(config('table.delimiter'))
        ->delimiter($delimiter)->toBeInstanceOf(Table::class)
        ->getDelimiter()->toBe($delimiter);
});

it('has key', function () {
    $key = 'test';

    // Class-based
    expect($this->table)
        ->getRecordKey()->toBe('id')
        ->key($key)->toBe($this->table)
        ->getRecordKey()->toBe($key);

    // Anonymous
    expect(Table::make())
        ->key($key)->toBeInstanceOf(Table::class)
        ->getRecordKey()->toBe($key);

    // Errors
    expect(fn () => Table::make()->getRecordKey())
        ->toThrow(\RuntimeException::class);
});

it('has endpoint', function () {
    $endpoint = '/other';

    // Class-based
    expect($this->table)
        ->getEndpoint()->toBe(config('table.endpoint'))
        ->endpoint($endpoint)->toBe($this->table)
        ->getEndpoint()->toBe($endpoint);

    // Anonymous
    expect(Table::make())
        ->getEndpoint()->toBe(config('table.endpoint'))
        ->endpoint($endpoint)->toBeInstanceOf(Table::class)
        ->getEndpoint()->toBe($endpoint);
});

it('has attributes', function () {
    $attributes = true;

    // Class-based
    expect($this->table)
        ->isWithAttributes()->toBe(config('table.attributes'))
        ->withAttributes($attributes)->toBe($this->table)
        ->isWithAttributes()->toBe($attributes);

    // Anonymous
    expect(Table::make())
        ->isWithAttributes()->toBe(config('table.attributes'))
        ->withAttributes($attributes)->toBeInstanceOf(Table::class)
        ->isWithAttributes()->toBe($attributes);
});

it('has array representation', function () {
    expect($this->table->toArray())
        ->{'id'}->toBeString()
        ->{'sorts'}->toHaveCount(4)
        ->{'filters'}->toHaveCount(7)
        ->{'searches'}->toBeEmpty()
        ->{'columns'}->toHaveCount(9)
        ->{'recordsPerPage'}->toHaveCount(3)
        ->{'records'}->toBeEmpty()
        ->{'paginator'}->not->toBeEmpty()
        ->{'toggleable'}->toBeTrue()
        ->{'actions'}->scoped(fn ($actions) => $actions
            ->{'hasInline'}->toBeTrue()
            ->{'bulk'}->toHaveCount(1)
            ->{'page'}->toHaveCount(2)
        )
        ->{'config'}->toEqual([
            'delimiter' => config('table.delimiter'),
            'search' => null,
            'searches' => config('table.searches_key'),
            'sorts' => config('table.sorts_key'),
            'matches' => config('table.matches_key'),
            'endpoint' => config('table.endpoint'),
            'record' => 'id',
            'records' => config('table.records_key'),
            'columns' => config('table.columns_key'),
            'pages' => config('table.pages_key'),
        ])
        ->{'meta'}->toBeEmpty();
});

it('has array representation using withouts', function () {
    $this->table->withoutActions()
        ->withoutSorts()
        ->withoutFilters()
        ->withoutSearches()
        ->withoutColumns();

    expect($this->table->toArray())
        ->{'id'}->toBeNull()
        ->{'sorts'}->toBeEmpty()
        ->{'filters'}->toBeEmpty()
        ->{'searches'}->toBeEmpty()
        ->{'columns'}->toBeEmpty()
        ->{'recordsPerPage'}->toHaveCount(3)
        ->{'records'}->toBeEmpty()
        ->{'paginator'}->not->toBeEmpty()
        ->{'toggleable'}->toBeTrue()
        ->{'actions'}->scoped(fn ($actions) => $actions
            ->{'hasInline'}->toBeFalse()
            ->{'bulk'}->toBeEmpty()
            ->{'page'}->toBeEmpty()
        )
        ->{'config'}->toEqual([
            'delimiter' => config('table.delimiter'),
            'search' => null,
            'searches' => config('table.searches_key'),
            'sorts' => config('table.sorts_key'),
            'matches' => config('table.matches_key'),
            'endpoint' => config('table.endpoint'),
            'record' => 'id',
            'records' => config('table.records_key'),
            'columns' => config('table.columns_key'),
            'pages' => config('table.pages_key'),
        ])
        ->{'meta'}->toBeEmpty();
});

it('retrieves records with attributes', function () {
    $product = product();

    $request = Request::create('/', 'GET');

    $columns = $this->table->getColumns();

    expect($this->table)
        ->isWithAttributes()->toBeFalse()
        ->withAttributes()->toBe($this->table)
        ->isWithAttributes()->toBeTrue();

    $this->table->retrieveRecords($product, $request, $columns);

    $colKeys = \array_map(fn (Column $column) => $column->getParameter(), $columns);

    $keys = \array_unique(
        \array_merge(
            $colKeys, 
            \array_keys($product->toArray()), 
            ['actions']
        )
    );

    expect($this->table->getRecords())
        ->{0}->scoped(fn ($record) => $record
            ->toHaveKeys($keys)
            ->toHaveCount(\count($keys))
            ->{'actions'}->toHaveCount(2) // ID not divisible by 2
        );
});

it('creates records', function () {
    $product = product();

    $columns = $this->table->getColumns();

    $actions = $this->table->getInlineActions();

    $names = \array_map(
        static fn (Column $column) => $column->getParameter(), 
        $columns
    );

    expect($this->table->createRecord($product, $columns, $actions))
        ->toBeArray()
        ->toHaveKeys([
            ...$names,
            'actions'
        ])->{'actions'}->toHaveCount(3);

    $product = product();

    expect($this->table->createRecord($product, $columns, $actions))
        ->toBeArray()
        ->toHaveKeys([
            ...$names,
            'actions'
        ])->{'actions'}->toHaveCount(2);
});

it('retrieves records', function () {
    foreach (range(1, 100) as $i) {
        product();
    }

    $builder = Product::query();

    $request = Request::create('/', 'GET', [
        config('table.pages_key') => 2,
        config('table.records_key') => 25,
    ]);

    $columns = $this->table->getColumns();

    $this->table->retrieveRecords($builder, $request, $columns);

    expect($this->table)
        ->getRecords()->toHaveCount(25)
        ->getPaginationData()->toHaveKeys([
            'empty',
            'prevLink',
            'nextLink',
            'perPage',
            'currentPage',
            'total',
            'from',
            'to',
            'firstLink',
            'lastLink',
            'links',
        ]);
});

// it('retrieves records', function () {
//     $product = product();

//     $request = Request::create('/', 'GET');

//     $columns = $this->table->getColumns();

//     $this->table->retrieveRecords($product, $request, $columns);

//     $keys = [...array_map(fn (Column $column) => $column->getParameter(), $columns), 'actions'];

//     expect($this->table->getRecords())
//         ->{0}->scoped(fn ($record) => $record
//             ->toHaveKeys($keys)
//             ->toHaveCount(\count($keys))
//             ->{'actions'}->toHaveCount(2) // ID not divisible by 2
//         );
// });
