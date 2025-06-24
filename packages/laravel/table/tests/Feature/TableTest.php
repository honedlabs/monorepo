<?php

declare(strict_types=1);

use Honed\Table\Columns\KeyColumn;
use Honed\Table\EmptyState;
use Honed\Table\Exceptions\KeyNotFoundException;
use Honed\Table\Table;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Workbench\App\Models\Product;
use Workbench\App\Tables\ProductTable;

beforeEach(function () {
    $this->table = Table::make()->for(Product::class);
});

afterEach(function () {
    Table::flushState();
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
        return Str::of($class)
            ->classBasename()
            ->prepend('Workbench\\App\\Tables\\')
            ->append('Table')
            ->value();
    });

    expect(ProductTable::resolveTableName(Product::class))
        ->toBe(ProductTable::class);

    expect(ProductTable::tableForModel(Product::class))
        ->toBeInstanceOf(ProductTable::class);
});

it('uses namespace', function () {
    ProductTable::useNamespace('');

    expect(ProductTable::resolveTableName(Product::class))
        ->toBe(Str::of(ProductTable::class)
            ->classBasename()
            ->prepend('Models\\')
            ->value()
        );
});

it('has array representation', function () {
    expect($this->table->toArray())
        ->toBeArray();
})->todo();

it('serializes to json', function () {
    expect($this->table->jsonSerialize())
        ->toBeArray();
})->todo();

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
