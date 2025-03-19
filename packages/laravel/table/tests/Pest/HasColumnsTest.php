<?php

declare(strict_types=1);

use Honed\Table\Columns\Column;
use Honed\Table\Table;
use Honed\Table\Tests\Fixtures\Table as FixtureTable;
use Honed\Table\Columns\KeyColumn;

beforeEach(function () {
    $this->table = FixtureTable::make();
});

it('has columns', function () {
    // Class-based
    expect($this->table)
        ->hasColumns()->toBeTrue()
        ->getColumns()->toHaveCount(9);

    // Anonymous
    expect(Table::make())
        ->hasColumns()->toBeFalse()
        ->columns([Column::make('id')->allow(false), Column::make('public_id')])->toBeInstanceOf(Table::class)
        ->hasColumns()->toBeTrue()
        ->getColumns()->toHaveCount(1);
});

it('has sortable columns', function () {
    // Class-based
    expect($this->table)
        ->getColumnSorts()->toHaveCount(2)
        ->each(fn ($column) => $column
            ->toBeInstanceOf(Column::class)
            ->isSortable()->toBeTrue()
        );

    // Anonymous
    expect(Table::make())
        ->getColumnSorts()->toBeEmpty();
});

it('has searchable columns', function () {
    expect($this->table)
        ->getColumnSearches()->toHaveCount(1)
        ->each(fn ($column) => $column
            ->toBeInstanceOf(Column::class)
            ->isSearchable()->toBeTrue()
        );

    expect(Table::make())
        ->getColumnSearches()->toBeEmpty();
});

it('has a key column', function () {
    expect($this->table->getKeyColumn())
        ->toBeInstanceOf(KeyColumn::class)
        ->getName()->toBe('id')
        ->isKey()->toBeTrue();

    expect(Table::make()->getKeyColumn())
        ->toBeNull();
});

it('can disable columns', function () {
    expect($this->table)
        ->isWithoutColumns()->toBeFalse()
        ->getColumns()->toHaveCount(9)
        ->columnsToArray()->toHaveCount(9)
        ->withoutColumns()->toBe($this->table)
        ->isWithoutColumns()->toBeTrue()
        ->getColumns()->toHaveCount(9)
        ->columnsToArray()->toBeEmpty();
});
