<?php

use function Pest\Laravel\get;

it('dummy', function () {
    $product = product();
    $response = get(route('product.show', $product));
    
    dd([
        'bound_model' => request()->route()->parameter('product'),
        'type' => get_class(request()->route()->parameter('product')),
    ]);
});