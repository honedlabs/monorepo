<?php

use Honed\Crumb\Attributes\Crumb;

use Honed\Crumb\Tests\Stubs\ProductController;

it('can be set on a class', function () {
    expect(collect((new \ReflectionClass(ProductController::class))
        ->getAttributes(Crumb::class)
    )->first()->newInstance()->getCrumb())->toBe('Products');
});

it('can be set on a method', function () {
    expect(collect((new \ReflectionMethod(ProductController::class, 'show'))
        ->getAttributes(Crumb::class)
    )->first()->newInstance()->getCrumb())->toBe('Products');
});