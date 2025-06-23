<?php

declare(strict_types=1);

use Honed\Table\Columns\Column;
use Honed\Table\Columns\KeyColumn;
use Honed\Table\Pipes\Toggle;
use Honed\Table\Table;
use Illuminate\Support\Facades\Request;

beforeEach(function () {
    $this->pipe = new Toggle();

    $this->columns = [
        KeyColumn::make('id'),
        Column::make('name'),
        Column::make('description'),
        Column::make('price'),
        Column::make('status'),
    ];

    $this->table = Table::make()
        ->toggle(true)
        ->orderable(true)
        ->columns($this->columns);
});

it('orders columns when orderable and column names provided', function () {
    // Request with columns in different order: description,name
    $request = Request::create('/', 'GET', [
        config('table.column_key') => 'description,name',
    ]);

    $this->table->request($request);

    $this->pipe->run($this->table);

    $headings = $this->table->getHeadings();

    // Check that the first column is now 'description' and second is 'name'
    expect($headings[0]->getParameter())->toBe('description');
    expect($headings[1]->getParameter())->toBe('name');
});

it('does not reorder when not orderable', function () {
    $this->table->orderable(false);

    $request = Request::create('/', 'GET', [
        config('table.column_key') => 'description,name',
    ]);

    $this->table->request($request);

    $this->pipe->run($this->table);

    $headings = $this->table->getHeadings();

    // Should maintain original order
    expect($headings[0]->getParameter())->toBe('id');
    expect($headings[1]->getParameter())->toBe('name');
});

it('does not reorder when no column names provided', function () {
    $request = Request::create('/', 'GET', []);

    $this->table->request($request);

    $this->pipe->run($this->table);

    $headings = $this->table->getHeadings();

    // Should maintain original order
    expect($headings[0]->getParameter())->toBe('id');
    expect($headings[1]->getParameter())->toBe('name');
});

it('handles partial column ordering', function () {
    // Request with only some columns specified
    $request = Request::create('/', 'GET', [
        config('table.column_key') => 'price,description',
    ]);

    $this->table->request($request);

    $this->pipe->run($this->table);

    $headings = $this->table->getHeadings();

    // Check that specified columns come first in the specified order
    expect($headings[0]->getParameter())->toBe('price');
    expect($headings[1]->getParameter())->toBe('description');

    // Other columns should follow in their original order
    expect($headings[2]->getParameter())->toBe('id');
    expect($headings[3]->getParameter())->toBe('name');
    expect($headings[4]->getParameter())->toBe('status');
});

it('handles non-existent column names gracefully', function () {
    $request = Request::create('/', 'GET', [
        config('table.column_key') => 'non-existent,description',
    ]);

    $this->table->request($request);

    $this->pipe->run($this->table);

    $headings = $this->table->getHeadings();

    // Should skip non-existent columns and order the rest
    expect($headings[0]->getParameter())->toBe('description');
});

it('maintains column visibility logic while ordering', function () {
    // Set up columns with some that are not toggleable
    $this->columns = [
        KeyColumn::make('id'),
        Column::make('name')->always(),
        Column::make('description'),
        Column::make('price')->sometimes(),
        Column::make('status'),
    ];

    $this->table = Table::make()
        ->toggle(true)
        ->orderable(true)
        ->columns($this->columns);

    $request = Request::create('/', 'GET', [
        config('table.column_key') => 'status,description',
    ]);

    $this->table->request($request);

    $this->pipe->run($this->table);

    $headings = $this->table->getHeadings();

    // Should only include active columns and order them correctly
    expect($headings[0]->getParameter())->toBe('status');
    expect($headings[1]->getParameter())->toBe('description');
});
