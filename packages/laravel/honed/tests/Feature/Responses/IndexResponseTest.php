<?php

declare(strict_types=1);

use Workbench\App\Responses\IndexProduct;
use Workbench\App\Tables\ProductTable;

beforeEach(function () {
    $this->response = new IndexProduct();
});

it('has index page', function () {
    expect($this->response)
        ->getPage()->toBe('Index');
});

it('has props', function () {
    expect($this->response)
        ->getProps()
        ->scoped(fn ($props) => $props
            ->toBeArray()
            ->toBeEmpty()
        )
        ->table(ProductTable::class)
        ->getProps()
        ->scoped(fn ($props) => $props
            ->toBeArray()
            ->toHaveCount(1)
            ->toHaveKey(IndexProduct::TABLE_PROP)
        );
});
