<?php

declare(strict_types=1);

use Honed\Table\Columns\KeyColumn;
use Honed\Table\EmptyState;
use Honed\Table\Exceptions\KeyNotFoundException;
use Honed\Table\Table;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Workbench\App\Models\Product;
use Workbench\App\Tables\ProductTable;

beforeEach(function () {
    $this->table = Table::make()->for(Product::class);
});

it('has key', function () {
    expect($this->table)
        ->columns(KeyColumn::make('id'))
        ->getKey()->toBe('id')
        ->key('test')->toBe($this->table)
        ->getKey()->toBe('test');
});

it('requires key', function () {
    $this->table->getKey();
})->throws(KeyNotFoundException::class);

it('is url routable', function () {
    expect($this->table)
        ->getRouteKeyName()->toBe('table');

    expect($this->table)
        ->resolveRouteBinding($this->table->getRouteKey())
        ->toBeNull();

    $table = ProductTable::make();

    expect($table)
        ->resolveRouteBinding($table->getRouteKey())
        ->toBeInstanceOf(ProductTable::class);

    expect($table)
        ->resolveChildRouteBinding(null, $table->getRouteKey())
        ->toBeInstanceOf(ProductTable::class);
});

it('resolves table', function () {
    ProductTable::guessTableNamesUsing(function ($class) {
        return $class.'Table';
    });

    expect(ProductTable::resolveTableName(Product::class))
        ->toBe('Workbench\\App\\Tables\\ProductTable');

    expect(ProductTable::tableForModel(Product::class))
        ->toBeInstanceOf(ProductTable::class);

    ProductTable::flushState();
});

it('uses namespace', function () {
    ProductTable::useNamespace('');

    expect(ProductTable::resolveTableName(Product::class))
        ->toBe('Honed\\Table\\Tests\\Stubs\\ProductTable');

    ProductTable::flushState();
});

describe('evaluation', function () {
    it('named dependencies', function ($closure, $class) {
        expect($this->table->evaluate($closure))->toBeInstanceOf($class);
    })->with([
        fn () => [fn ($emptyState) => $emptyState, EmptyState::class],
        fn () => [fn ($builder) => $builder, Builder::class],
        fn () => [fn ($query) => $query, Builder::class],
        fn () => [fn ($q) => $q, Builder::class],
        fn () => [fn ($request) => $request, Request::class],
    ]);

    it('typed dependencies', function ($closure, $class) {
        expect($this->table->evaluate($closure))->toBeInstanceOf($class);
    })->with([
        fn () => [fn (EmptyState $arg) => $arg, EmptyState::class],
        fn () => [fn (Request $arg) => $arg, Request::class],
        fn () => [fn (Builder $arg) => $arg, Builder::class],
        fn () => [fn (BuilderContract $arg) => $arg, Builder::class],
        fn () => [fn (Table $arg) => $arg, Table::class],
    ]);
});
