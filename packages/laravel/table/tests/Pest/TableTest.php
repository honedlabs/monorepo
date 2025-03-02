<?php

declare(strict_types=1);

use Honed\Table\Table;
use Honed\Table\Tests\Fixtures\Table as FixtureTable;
use Illuminate\Database\Eloquent\Builder;

// Test the added properties of the table

beforeEach(function () {
    $this->test = Table::make();
});

it('has key', function () {
    $key = 'test';

    // Class-based
    expect($this->test)
        ->key($key)->toBe($this->test)
        ->getRecordKey()->toBe($key);

    // Anonymous
    expect(Table::make())
        ->key($key)->toBeInstanceOf(Table::class)
        ->getRecordKey()->toBe($key);
});

it('errors if no key is set', function () {
    expect(fn () => Table::make()->getRecordKey())
        ->toThrow(\RuntimeException::class);
});

it('has endpoint', function () {
    $endpoint = '/other';

    // Class-based
    expect($this->test)
        ->getEndpoint()->toBe(FixtureTable::Endpoint)
        ->endpoint($endpoint)->toBe($this->test)
        ->getEndpoint()->toBe($endpoint);

    // Anonymous
    expect(Table::make())
        ->getEndpoint()->toBe(config('table.endpoint'))
        ->endpoint($endpoint)->toBeInstanceOf(Table::class)
        ->getEndpoint()->toBe($endpoint);
});