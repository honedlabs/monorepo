<?php

declare(strict_types=1);

use Honed\Table\Tests\Fixtures\Table as FixtureTable;
use Honed\Table\Table;

beforeEach(function () {
    $this->test = FixtureTable::make();
});

it('has a sorts key', function () {
    $sortsKey = 's';

    // Class-based
    expect($this->test)
        ->getSortsKey()->toBe(FixtureTable::SortsKey)
        ->sortsKey($sortsKey)->toBe($this->test)
        ->getSortsKey()->toBe($sortsKey);

    // Anonymous
    expect(Table::make())
        ->getSortsKey()->toBe(config('table.config.sorts'))
        ->sortsKey($sortsKey)->toBeInstanceOf(Table::class)
        ->getSortsKey()->toBe($sortsKey);
});

it('has a searches key', function () {
    $searchesKey = 's';

    // Class-based
    expect($this->test)
        ->getSearchesKey()->toBe(FixtureTable::SearchesKey)
        ->searchesKey($searchesKey)->toBe($this->test)
        ->getSearchesKey()->toBe($searchesKey);

    // Anonymous
    expect(Table::make())
        ->getSearchesKey()->toBe(config('table.config.searches'))
        ->searchesKey($searchesKey)->toBeInstanceOf(Table::class)
        ->getSearchesKey()->toBe($searchesKey);
});

it('can match', function () {
    $canMatch = true;

    // Class-based
    expect($this->test)
        ->canMatch()->toBe(config('table.matches'));

    expect($this->test->match($canMatch))
        ->toBe($this->test)
        ->canMatch()->toBe($canMatch);

    // Anonymous
    expect(Table::make())
        ->canMatch()->toBe(config('table.matches'));

    expect(Table::make()->match($canMatch))
        ->toBeInstanceOf(Table::class)
        ->canMatch()->toBe($canMatch);
});

it('has a delimiter', function () {
    $delimiter = '|';

    // Class-based
    expect($this->test)
        ->getDelimiter()->toBe(FixtureTable::Delimiter)
        ->delimiter($delimiter)->toBe($this->test)
        ->getDelimiter()->toBe($delimiter);

    // Anonymous
    expect(Table::make())
        ->getDelimiter()->toBe(config('table.config.delimiter'))
        ->delimiter($delimiter)->toBeInstanceOf(Table::class)
        ->getDelimiter()->toBe($delimiter);
});