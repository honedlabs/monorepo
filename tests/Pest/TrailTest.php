<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Pest;

use Honed\Crumb\Crumb;
use Honed\Crumb\Trail;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

it('can be instantiated', function () {
    expect(new Trail(Crumb::make('Home', '/')))
        ->toBeInstanceOf(Trail::class)
        ->hasCrumbs()->toBeTrue()
        ->missingCrumbs()->toBeFalse()
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

it('has array representation', function () {
    expect(Trail::make(Crumb::make('Home', '/'))->toArray())->toEqual([
        Crumb::make('Home', '/')
    ]);
});

it('can share crumbs', function () {
    expect(Trail::make(Crumb::make('Home', '/'))->share())->toBeInstanceOf(Trail::class);

    $response = get('/');

    $response->assertInertia(fn (Assert $page) => $page->has('crumbs')
        ->count('crumbs', 1)
        ->where('crumbs.0', [
            'name' => 'Home',
            'url' => '/',
        ]));
});
