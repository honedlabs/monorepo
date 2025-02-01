<?php

declare(strict_types=1);

use Honed\Nav\NavItem;
use Honed\Nav\Tests\Stubs\Product;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->label = 'Home';
});

it('can be made', function () {
    expect(NavItem::make($this->label, 'products.index'))->toBeInstanceOf(NavItem::class)
        ->getLabel()->toBe($this->label)
        ->getRoute()->toBe(route('products.index'));
});

it('tests', function () {
    get(route('products.show', product()));

    dd(request()->route()->named('products.*'));
});