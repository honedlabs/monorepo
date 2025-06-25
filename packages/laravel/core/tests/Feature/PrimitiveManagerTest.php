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

    Component::configureUsing(fn (Component $component) => $component->name('Users'));

    expect(Component::make())
        ->getName()->toBe('Users');
});

it('sets configuration', function () {
    Component::configureUsing(fn (Component $component) => $component->name('Users'));

    expect(Component::make())
        ->getName()->toBe('Users');
});

it('configure children primitives', function () {
    Component::configureUsing(fn (Component $component) => $component->name('Parent'));

    expect(Component::make())
        ->getName()->toBe('Parent');

    expect(ChildComponent::make())
        ->getName()->toBe('Parent');
});

it('does not configure non-matching primitives', function () {
    ChildComponent::configureUsing(fn (ChildComponent $component) => $component->name('Child'));

    expect(Component::make())
        ->getName()->toBeNull();

    expect(ChildComponent::make())
        ->getName()->toBe('Child');
});
