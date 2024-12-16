<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Pest;

use Honed\Crumb\Crumb;
use Honed\Crumb\Trail;

it('can be instantiated', function () {
    expect(new Trail(Crumb::make('Home', '/')))
        ->toBeInstanceOf(Trail::class)
        ->hasCrumbs()->toBeTrue()
        ->crumbs()->toEqual([
            Crumb::make('Home', '/')
        ]);
});

it('can be made', function () {
    expect(Trail::make(Crumb::make('Home', '/')))->toBeInstanceOf(Trail::class)
        ->hasCrumbs()->toBeTrue()
        ->crumbs()->toEqual([
            Crumb::make('Home', '/')
        ]);
});

it('can add crumb classes', function () {
    expect(Trail::make()->add(Crumb::make('Products', '/products')))->toBeInstanceOf(Trail::class)
        ->hasCrumbs()->toBeTrue()
        ->crumbs()->toEqual([
            Crumb::make('Products', '/products')
        ]);
});

it('can add crumbs being created', function () {
    expect(Trail::make()->add('Products', '/products'))->toBeInstanceOf(Trail::class)
        ->hasCrumbs()->toBeTrue()
        ->crumbs()->toEqual([
            Crumb::make('Products', '/products')
        ]);
});

it('can add multiple crumb classes', function () {
    expect(Trail::make()->add(Crumb::make('Products', '/products'), Crumb::make('Orders', '/orders')))->toBeInstanceOf(Trail::class)
        ->hasCrumbs()->toBeTrue()
        ->crumbs()->toEqual([
            Crumb::make('Products', '/products'),
            Crumb::make('Orders', '/orders'),
        ]);
});

it('can add multiple crumbs being created', function () {
    expect(Trail::make()->add(['Products', '/products', 'fa-solid fa-box'], ['Orders', '/orders', 'fa-solid fa-box']))->toBeInstanceOf(Trail::class)
        ->hasCrumbs()->toBeTrue()
        ->crumbs()->toEqual([
            Crumb::make('Products', '/products', 'fa-solid fa-box'),
            Crumb::make('Orders', '/orders', 'fa-solid fa-box'),
        ]);
});

it('has array representation', function () {
    expect(Trail::make(Crumb::make('Home', '/'))->toArray())->toEqual([
        Crumb::make('Home', '/')
    ]);
});
