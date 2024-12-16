<?php

declare(strict_types=1);

use Honed\Crumb\Manager;
use Honed\Crumb\Facades\Crumbs;


/** Must be accessed statically via facade */

it('can be accessed statically via facade', function () {
    expect(Crumbs::getFacadeRoot())->toBeInstanceOf(Manager::class);
});

it('has autoloads from `routes` file', function () {
    // dd(Crumbs::get('basic'));
});
