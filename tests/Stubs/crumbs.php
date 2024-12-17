<?php

use Honed\Crumb\Crumb;
use Honed\Crumb\Trail;
use Honed\Crumb\Facades\Crumbs;
use Honed\Crumb\Tests\Stubs\Status;
use Honed\Crumb\Tests\Stubs\Product;

Crumbs::for('basic', function (Trail $trail) {
    $trail->add('Home', '/');
});

Crumbs::for('products', function (Trail $trail) {
    $trail->add('Home', '/');
    $trail->add('Products', '/products');
    $trail->select(
        Crumb::make(fn (Product $product) => $product->name, fn (Product $product) => route('product.show', $product)),
        Crumb::make(fn (Product $product) => sprintf('Edit %s', $product->name), fn (Product $product) => route('product.edit', $product))
    );
});

Crumbs::for('status', function (Trail $trail) {
    $trail->add('Home', '/');
    $trail->add('Statuses', '/statuses'); // A page which does not exist
    $trail->add(Crumb::make(fn (Status $status) => $status->value, fn (Status $status) => route('status.show', $status)));
});