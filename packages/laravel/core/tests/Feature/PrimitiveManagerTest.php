<?php

declare(strict_types=1);

use Honed\Core\Contracts\ScopedPrimitiveManager;
use Honed\Core\PrimitiveManager;
use Workbench\App\Classes\ChildComponent;
use Workbench\App\Classes\Component;

it('is bound to container', function () {
    expect(app(ScopedPrimitiveManager::class))
        ->toBeInstanceOf(PrimitiveManager::class);
});

it('resolves', function () {
    expect(PrimitiveManager::resolve())
        ->toBeInstanceOf(PrimitiveManager::class);

    app()->offsetUnset(ScopedPrimitiveManager::class);

    expect(PrimitiveManager::resolve())
        ->toBeInstanceOf(PrimitiveManager::class);

    Component::configureUsing(fn (Component $component) => $component->type('Users'));

    expect(Component::make())
        ->getType()->toBe('Users');
});

it('sets configuration', function () {
    Component::configureUsing(fn (Component $component) => $component->type('Users'));

    expect(Component::make())
        ->getType()->toBe('Users');
});

it('configure children primitives', function () {
    Component::configureUsing(fn (Component $component) => $component->type('Parent'));

    expect(Component::make())
        ->getType()->toBe('Parent');

    expect(ChildComponent::make())
        ->getType()->toBe('Parent');
});

it('does not configure non-matching primitives', function () {
    ChildComponent::configureUsing(fn (ChildComponent $component) => $component->type('Child'));

    expect(Component::make())
        ->getType()->toBeNull();

    expect(ChildComponent::make())
        ->getType()->toBe('Child');
});
