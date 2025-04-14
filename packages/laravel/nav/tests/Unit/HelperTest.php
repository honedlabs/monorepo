<?php

declare(strict_types=1);

use Honed\Nav\NavManager;
use Honed\Nav\NavItem;

it('has helper', function () {
    expect(nav())
        ->toBeInstanceOf(NavManager::class);
});

it('has helper with group', function () {
    expect(nav('primary', NavItem::make('Home', 'products.index')))
        ->toBeInstanceOf(NavManager::class);

    expect(nav()->group('primary'))
        ->toBeArray()
        ->toHaveCount(1);
});
