<?php

declare(strict_types=1);

use Honed\Table\Pipelines\CreateEmptyState;
use Honed\Table\Tests\Stubs\Product;
use Honed\Table\Table;

beforeEach(function () {
    $this->pipe = new CreateEmptyState();
    $this->next = fn ($table) => $table;

    $this->table = Table::make()
        ->resource(Product::query());
});

it('has default empty state', function () {
    $this->pipe->__invoke($this->table, $this->next);

    expect($this->table->getEmptyState())
        ->getTitle()->toBe(config('table.empty_state.title'))
        ->getMessage()->toBe(config('table.empty_state.message'))
        ->getIcon()->toBe(config('table.empty_state.icon'))
        ->getLabel()->toBeNull()
        ->getAction()->toBeNull();
});

it('has searching state', function () {

});

it('has filtering state', function () {

});

it('has refining state', function () {

});
