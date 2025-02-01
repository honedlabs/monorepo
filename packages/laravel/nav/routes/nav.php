<?php

declare(strict_types=1);

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavGroup;
use Honed\Nav\NavItem;

// Nav::make('sidebar', [
//     NavGroup::make('Pages', [
//         NavItem::make('Home', 'home.index'),
//         NavItem::make('Product', fn ($product) => route('product.show', $product)),
//     ]),
//     NavGroup::make('Pages', [
//         NavItem::make('Home', 'home.index'),
//         NavItem::make('Product', fn ($product) => route('product.show', $product)),
//     ]),
// ]);