<?php

declare(strict_types=1);

use Honed\Crumb\Crumb;
use Honed\Crumb\Exceptions\CrumbsNotFoundException;
use Honed\Crumb\Exceptions\DuplicateCrumbsException;
use Honed\Crumb\Facades\Crumbs;
use Honed\Crumb\Manager;
use Honed\Crumb\Trail;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

/** Must be accessed statically via facade */
it('can be accessed statically via facade', function () {
    expect(Crumbs::getFacadeRoot())->toBeInstanceOf(Manager::class);
});

it('has autoloads from `routes` file', function () {
    expect(Crumbs::get('basic'))->toBeInstanceOf(Trail::class)
        ->toArray()->toHaveCount(1);
});

it('can set crumbs before all other crumbs', function () {
    Crumbs::before(function (Trail $trail) {
        $trail->add(Crumb::make('Products', '/products'));
    });

    expect(Crumbs::get('basic'))->toBeInstanceOf(Trail::class)
        ->toArray()->toHaveCount(2);
});

it('throws error if the key does not exist', function () {
    Crumbs::get('not-found');
})->throws(CrumbsNotFoundException::class);

it('throws error if the key already exists', function () {
    Crumbs::for('basic', function (Trail $trail) {
        $trail->add(Crumb::make('Home', '/'));
    });
})->throws(DuplicateCrumbsException::class);

it('can retrieve breadcrumbs with locking', function () {
    $product = product();

    $response = get(route('product.show', $product));

    $response->assertInertia(fn (Assert $page) => $page->has('crumbs')
        ->count('crumbs', 3)
        ->where('crumbs.0', [
            'name' => 'Home',
            'url' => '/',
        ])
        ->where('crumbs.1', [
            'name' => 'Products',
            'url' => '/products',
        ])
        ->where('crumbs.2', [
            'name' => $product->name,
            'url' => route('product.show', $product),
        ]));
});

it('can shortcut breadcrumbs', function () {
    $response = get(route('product.index'));

    $response->assertInertia(fn (Assert $page) => $page->has('crumbs')
        ->count('crumbs', 2)
        ->where('crumbs.0', [
            'name' => 'Home',
            'url' => '/',
        ])
        ->where('crumbs.1', [
            'name' => 'Products',
            'url' => '/products',
        ]));
});
