<?php

declare(strict_types=1);

use Honed\Table\Columns\Column;
use Honed\Table\Table;
use Honed\Table\Contracts\ShouldSelect;
use Illuminate\Support\Facades\Request;
use Honed\Table\Tests\Fixtures\Table as FixtureTable;
use Honed\Table\Tests\Stubs\Product;

beforeEach(function () {
    $this->table = FixtureTable::make();
});

it('is selectable', function () {
    // Class-based
    expect($this->table)
        ->isSelectable()->toBe(false)
        ->selectable(false)->toBe($this->table)
        ->isSelectable()->toBe(false);

    // Anonymous
    expect(Table::make())
        ->isSelectable()->toBe(config('table.select'))
        ->selectable()->toBeInstanceOf(Table::class)
        ->isSelectable()->toBe(true);

    // Via interface
    $class = new class extends Table implements ShouldSelect {
        public function __construct() {}
    };

    expect($class)
        ->isSelectable()->toBe(true)
        ->selectable(false)->toBe($class)
        ->isSelectable()->toBe(false);
});

it('sets select columns', function () {
    // Class-based
    expect($this->table)
        ->selects('name')->toBe($this->table)
        ->getSelects()->toBe(['name']);

    // Anonymous
    expect(Table::make())
        ->selects(['name'])->toBeInstanceOf(Table::class)
        ->getSelects()->toBe(['name']);
});

it('does not select columns if not selectable', function () {

});

it('selects columns from builder', function () {

});

it('selects columns from builder with added columns', function () {

});

it('selects with joins', function () {
    product();
    /** @var \Illuminate\Database\Eloquent\Builder<\Honed\Table\Tests\Stubs\Product> */
    $builder = Product::query()
        ->join('sellers', 'products.seller_id', '=', 'sellers.id');

    $table = Table::make()
        ->for($builder)
        ->columns([
            Column::make('products.name')
                ->alias('name'),
            Column::make('sellers.name')
        ])
        ->selectable();

    $table->build();

    expect($builder->getQuery()->columns)
        ->toEqual(['products.name', 'sellers.name']);
});
