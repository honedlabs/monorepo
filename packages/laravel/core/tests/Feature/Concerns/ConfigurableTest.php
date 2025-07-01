<?php

declare(strict_types=1);

use Workbench\App\Classes\Component;

afterEach(function () {
    Component::configureUsing(fn (Component $component) => $component);
});

it('can be configured using a callback', function () {
    expect(Component::make())
        ->getType()->toBeNull();

    Component::configureUsing(fn (Component $component) => $component->type('Configurable'));

    expect(Component::make())
        ->getType()->toBe('Configurable');
});

it('call the definition method', function () {
    expect(Component::make())
        ->getName()->toBe('component');
});
