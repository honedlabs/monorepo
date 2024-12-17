<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Pest;

use Honed\Crumb\Crumb;
use Honed\Crumb\Trail;
use function Pest\Laravel\get;

use Inertia\Testing\AssertableInertia as Assert;
use Honed\Crumb\Exceptions\CrumbUnlockedException;

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

it('has array representation', function () {
    expect(Trail::make(Crumb::make('Home', '/'))->toArray())->toEqual([
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

it('is not locking by default', function () {
    expect(Trail::make())
        ->isLocking()->toBeFalse()
        ->isNotLocking()->toBeTrue();
});

it('is not locked by default', function () {
    expect(Trail::make())
        ->isLocked()->toBeFalse()
        ->isNotLocked()->toBeTrue();
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

it('throws error if trying to access non-locking trail', function () {
    Trail::make(Crumb::make('Home', '/'))->select(Crumb::make('Products', '/products'));
})->throws(CrumbUnlockedException::class);