<?php

declare(strict_types=1);

use Honed\Crumb\Crumb;
use Honed\Crumb\Trail;
use Honed\Crumb\Manager;
use Honed\Crumb\Facades\Crumbs;
use Honed\Crumb\Exceptions\CrumbsNotFoundException;
use Honed\Crumb\Exceptions\DuplicateCrumbsException;

/** Must be accessed statically via facade */

it('can be accessed statically via facade', function () {
    expect(Crumbs::getFacadeRoot())->toBeInstanceOf(Manager::class);
});

it('has autoloads from `routes` file', function () {
    expect(Crumbs::get('basic'))->toBeInstanceOf(Trail::class)
        ->toArray()->toEqual([
            Crumb::make('Home', '/')
        ]);
});

it('can set crumbs before all other crumbs', function () {
    Crumbs::before(function (Trail $trail) {
        $trail->add(Crumb::make('Products', '/products'));
    });

    expect(Crumbs::get('basic'))->toBeInstanceOf(Trail::class)
        ->toArray()->toEqual([
            Crumb::make('Products', '/products'),
            Crumb::make('Home', '/'),
        ]);
});

it('can set crumbs after all other crumbs', function () {
    Crumbs::after(function (Trail $trail) {
        $trail->add(Crumb::make('Products', '/products'));
    });
    
    expect(Crumbs::get('basic'))->toBeInstanceOf(Trail::class)
        ->toArray()->toEqual([
            Crumb::make('Home', '/'),
            Crumb::make('Products', '/products'),
        ]);
});

it('throws error if the key does not exist', function () {
    Crumbs::get('not-found');
})->throws(CrumbsNotFoundException::class);

it('throws error if the key already exists', function () {
    Crumbs::for('basic', function (Trail $trail) {
        $trail->add(Crumb::make('Home', '/'));
    });
})->throws(DuplicateCrumbsException::class);
