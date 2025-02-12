<?php

declare(strict_types=1);

use Honed\Table\Table;
use Honed\Table\Tests\Stubs\Product;

beforeEach(function () {
    $this->builder = Product::query();
});

it('can be created', function () {
    expect(Table::make())
        ->toBeInstanceOf(Table::class);
});

it('sets a query', function () {
    expect(Table::make()->builder($this->builder))
        ->toBeInstanceOf(Table::class);
});
