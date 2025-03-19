<?php

use Honed\Table\Table;
use Honed\Table\Columns\Column;
use Honed\Table\Contracts\ShouldToggle;
use Illuminate\Support\Facades\Request;
use Honed\Table\Contracts\ShouldRemember;
use Honed\Table\Tests\Fixtures\Table as FixtureTable;

beforeEach(function () {
    $this->table = FixtureTable::make();
});

it('is toggleable', function () {
    // Class-based
    expect($this->table)
        ->isToggleable()->toBe(true)
        ->toggleable(false)->toBe($this->table)
        ->isToggleable()->toBe(false);

    // Anonymous
    expect(Table::make())
        ->isToggleable()->toBe(config('table.toggle'))
        ->toggleable(true)->toBeInstanceOf(Table::class)
        ->isToggleable()->toBe(true);

    // Via interface
    $class = new class extends Table implements ShouldToggle {
        public function __construct() {}
    };

    expect($class)
        ->isToggleable()->toBe(true)
        ->toggleable(false)->toBe($class)
        ->isToggleable()->toBe(false);
});

it('has columns key', function () {
    $columnsKey = 'columns';

    // Class-based
    expect($this->table)
        ->getColumnsKey()->toBe(config('table.columns_key'))
        ->columnsKey($columnsKey)
        ->getColumnsKey()->toBe($columnsKey);

    // Anonymous
    expect(Table::make())
        ->getColumnsKey()->toBe(config('table.columns_key'))
        ->columnsKey($columnsKey)
        ->getColumnsKey()->toBe($columnsKey);
});

it('can remember', function () {
    // Class-based
    expect($this->table)
        ->isRememberable()->toBe(true)
        ->rememberable(false)->toBe($this->table)
        ->isRememberable()->toBe(false);

    // Anonymous
    expect(Table::make())
        ->isRememberable()->toBe(config('table.remember'))
        ->rememberable(true)->toBeInstanceOf(Table::class)
        ->isRememberable()->toBe(true);

    // Via interface
    $class = new class extends Table implements ShouldRemember {
        public function __construct() {}
    };

    expect($class)
        ->isToggleable()->toBe(true)
        ->isRememberable()->toBe(true)
        ->remember(true)->toBe($class)
        ->isRememberable()->toBe(true);
});

it('has cookie name', function () {
    $cookieName = 'cookie';

    // Class-based
    expect($this->table)
        ->getCookieName()->toBe($this->table->guessCookieName())
        ->cookieName($cookieName)
        ->getCookieName()->toBe($cookieName);
        
    // Anonymous
    expect(Table::make())
        ->getCookieName()->toBe('table')
        ->cookieName($cookieName)
        ->getCookieName()->toBe($cookieName);
});

it('has duration', function () {
    $duration = 100;

    // Class-based
    expect($this->table)
        ->getDuration()->toBe(config('table.duration'))
        ->duration($duration)->toBe($this->table)
        ->getDuration()->toBe($duration);

    // Anonymous
    expect(Table::make())
        ->getDuration()->toBe(config('table.duration'))
        ->duration($duration)->toBeInstanceOf(Table::class)
        ->getDuration()->toBe($duration);
});

it('toggles column activity', function () {
    $key = $this->table->formatScope($this->table->getColumnsKey());

    $request = Request::create('/', 'GET', [
        $key => \sprintf('%s%s%s', 'cost', $this->table->getDelimiter(), 'created_at')
    ]);

    $this->table->request($request)->build();

    $columns = \array_values(
        \array_filter(
            $this->table->getColumns(),
            static fn (Column $column) => $column->isActive()
        )
    );

    expect($columns)->toHaveCount(5);
});

it('can disable toggling', function () {
    $request = Request::create('/', 'GET');

    $columns = $this->table->getColumns();

    expect($this->table->request($request)->build())
        ->isWithoutToggling()->toBeFalse()
        ->withoutToggling()->toBe($this->table)
        ->isWithoutToggling()->toBeTrue()
        ->toggle($request, $columns)->toHaveCount(7);
});
