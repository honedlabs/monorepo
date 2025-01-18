<?php

declare(strict_types=1);

use Honed\Refining\Tests\Stubs\Product;

it('tests', function () {
    dd(Product::query()->qualifyColumn('products.name'));
});
