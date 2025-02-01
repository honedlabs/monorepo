<?php

use Honed\Nav\Facades\Nav;
use Honed\Nav\Nav as NavNav;
use Honed\Nav\NavItem;

it('has a facade', function () {
    expect(Nav::items(NavItem::make('Home', 'products.index')))->toBeInstanceOf(NavNav::class);
});
