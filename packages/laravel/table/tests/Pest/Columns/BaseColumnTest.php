<?php

declare(strict_types=1);

use Honed\Table\Columns\Column;
use Honed\Table\Tests\Stubs\Product;

beforeEach(function () {
    $this->name = 'name';
    $this->column = Column::make($this->name);
});

it('can be instantiated', function () {
    expect(new Column($this->name))->toBeInstanceOf(Column::class)
        ->getName()->toBe($this->name)
        ->getLabel()->toBe('Name');
});

it('can be made', function () {
    expect(Column::make($this->name))->toBeInstanceOf(Column::class)
        ->getName()->toBe($this->name)
        ->getLabel()->toBe('Name');
});

it('has array representation', function () {
    expect($this->column->toArray())->toBeArray();
});

it('can be applied to a record', function () {
    $product = product();
    expect($this->column->transformer(fn (Product $product) => $product->name)
        ->apply($product))->toBe($product->name);
});

it('has a placeholder', function () {
    expect($this->column->placeholder('test'))->formatValue(null)->toBe('test');
});

// it('can format a record', function () {
//     expect($this->column->placeholder('test')
//         ->formatValue(null)->apply(Product::find(1)))->toBe('test');
// });