<?php

use Honed\Nav\Facades\Nav as NavFacade;
use Honed\Nav\Nav;
use Honed\Nav\NavGroup;
use Honed\Nav\NavItem;

beforeEach(function () {
    
    $this->product = product();

    NavFacade::make('nav', [NavItem::make('Home', 'products.index')]);

    NavFacade::make('sidebar', [
        NavGroup::make('Products', [
            NavItem::make('Index', 'products.index'),
            NavItem::make('Show', 'products.show', $this->product),
            NavItem::make('Edit', 'products.edit', $this->product)->allow(false),
        ]),
        NavGroup::make('More products', [
            NavItem::make('Index', 'products.index'),
            NavItem::make('Show', 'products.show', $this->product),
            NavItem::make('Edit', 'products.edit', $this->product)->allow(false),
        ])->allow(false),
    ]);
});

it('has a facade', function () {
    expect(NavFacade::make('nav', [NavItem::make('Home', 'products.index')]))
        ->toBeInstanceOf(Nav::class)
        ->group('nav')->scoped(fn ($group) => $group
            ->toBeArray()
            ->toHaveCount(1)
        );
});

it('can add items to a group', function () {
    expect(NavFacade::add('nav', [NavItem::make('Index', 'products.index')]))
        ->toBeInstanceOf(Nav::class);

    expect(NavFacade::group('nav'))
        ->toBeArray()
        ->toHaveCount(2);
});

it('can retrieve all items', function () {
    expect(NavFacade::get())
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['nav', 'sidebar'])
        ->{'nav'}->scoped(fn ($nav) => $nav
            ->toBeArray()
            ->toHaveCount(1)
        )->{'sidebar'}->scoped(fn ($sidebar) => $sidebar
            ->toBeArray()
            ->toHaveCount(1)
            ->{0}->scoped(fn ($group) => $group
                ->toBeInstanceOf(NavGroup::class)
                ->getLabel()->toBe('Products')
                ->getAllowedItems()->scoped(fn ($items) => $items
                    ->toBeArray()
                    ->toHaveCount(2)
                )
            )
        );
});

it('can retrieve items by group', function () {
    expect(NavFacade::get('sidebar'))
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($group) => $group
            ->toBeInstanceOf(NavGroup::class)
            ->getLabel()->toBe('Products')
            ->getAllowedItems()->scoped(fn ($items) => $items
                ->toBeArray()
                ->toHaveCount(2)
            )
        );
});

it('can retrieve multiple groups', function () {
    expect(NavFacade::get('nav', 'sidebar'))
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['nav', 'sidebar'])
        ->{'nav'}->scoped(fn ($nav) => $nav
            ->toBeArray()
            ->toHaveCount(1)
        )->{'sidebar'}->scoped(fn ($sidebar) => $sidebar
            ->toBeArray()
            ->toHaveCount(1)
            ->{0}->scoped(fn ($group) => $group
                ->toBeInstanceOf(NavGroup::class)
                ->getLabel()->toBe('Products')
                ->getAllowedItems()->scoped(fn ($items) => $items
                    ->toBeArray()
                    ->toHaveCount(2)
                )
            )
        );
});

it('can determine if a group has navigation', function () {
    expect(NavFacade::hasGroups('nav'))->toBeTrue();
    expect(NavFacade::hasGroups('nav', 'sidebar'))->toBeTrue();
    expect(NavFacade::hasGroups('nav', 'sidebar', 'products'))->toBeFalse();
});
