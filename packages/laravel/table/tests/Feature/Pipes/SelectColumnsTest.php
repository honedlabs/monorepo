<?php

declare(strict_types=1);

use Honed\Refine\Filters\Filter;
use Honed\Refine\Sorts\Sort;
use Honed\Table\Columns\NumericColumn;
use Honed\Table\Columns\TextColumn;
use Honed\Table\Pipes\PrepareColumns;
use Honed\Table\Pipes\SearchColumns;
use Honed\Table\Table;
use Illuminate\Support\Facades\DB;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->pipe = new SearchColumns();

    $this->table = Table::make()
        ->for(Product::class)
        ->columns(NumericColumn::make('price'));
});

it('selects', function () {
    $this->pipe->through($this->table->selectable());

    expect($this->table)
        ->isSelectable()->toBeTrue()
        ->getSelects()->toBe(['price']);
});

it('does not select if not active', function () {
    $this->pipe->through($this->table
        ->columns(NumericColumn::make('price')->active(false))
        ->selectable()
    );

    expect($this->table)
        ->isSelectable()->tobeTrue()
        ->getSelects()->toEqual(['price']);
});

it('does not select if not selectable', function () {
    $this->pipe->through($this->table
        ->selectable(false)
    );
    
    expect($this->table)
        ->isSelectable()->toBeFalse()
        ->getSelects()->toBeEmpty();
});
