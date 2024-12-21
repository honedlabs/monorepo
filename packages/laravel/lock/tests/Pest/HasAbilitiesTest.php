<?php

declare(strict_types=1);

use Honed\Lock\Tests\Stubs\Product;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->product = product();
});

it('can set abilities attribute to hidden', function () {
    // expect($this->product->withoutAbilities())->toBeInstanceOf(Product::class)
    //     ->getAttributes();
    dd($this->product);
    dd(get(route('product.show', $this->product)));
    get(route('product.show', $this->product))->assertInertia(fn (Assert $page) => 
        $page->has('product', fn (Assert $page) => $page->dd()));
        // where('abilities', $this->product->abilities())));
});
