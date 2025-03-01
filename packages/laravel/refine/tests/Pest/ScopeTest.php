<?php

declare(strict_types=1);

use Honed\Refine\Refine;
use Honed\Refine\Tests\Stubs\Product;

// This case verifies that query parameters can be scoped

beforeEach(function () {
    $this->builder = Product::query();

    $this->refine = Refine::make($this->builder)
        ->scope('products');
});

it('scopes filters', function () {
    $refine->filter;
});