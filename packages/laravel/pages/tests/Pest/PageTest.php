<?php

declare(strict_types=1);

use Honed\Pages\Page;

it('has root page', function () {
    expect(new Page('Index.vue'))
        ->getName()->toBe('Index')
        ->getPath()->toBe('Index')
        ->getUri()->toBe('index')
        ->hasBinding()->toBeFalse();
});

it('has nested page', function () {
    expect(new Page('Products/Index.vue'))
        ->getName()->toBe('Index')
        ->getPath()->toBe('Products/Index')
        ->getUri()->toBe('products/index')
        ->getBinding()->toBeNull();
});

it('has page with binding', function () {
    expect(new Page('Products/[Product].vue'))
        ->getName()->toBe('[Product]')
        ->getPath()->toBe('Products/[Product]')
        ->getBinding()->toBe('product')
        ->getUri()->toBe('products/{product}');
});

it('has nested page with binding', function () {
    expect(new Page('Products/[Product]/[ProductCategory].vue'))
        ->getName()->toBe('[ProductCategory]')
        ->getPath()->toBe('Products/[Product]/[ProductCategory]')
        // ->getBinding()->toBe(['product', 'productCategory'])
        // ->getUri()->toBe('products/{product}/{productCategory}')
        ;
});
