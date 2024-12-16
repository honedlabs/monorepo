<?php

use Honed\Crumb\Crumb;
use function Pest\Laravel\get;
use Honed\Crumb\Tests\Stubs\Product;

it('dummy', function () {
    $product = product();
    $response = get(route('product.show', $product));
    
    $crumb = Crumb::make(fn ($product) => $product->name)->route('product.show', $product);
    dd($crumb->toArray());
});