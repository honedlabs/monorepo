<?php

declare(strict_types=1);

use Workbench\App\Classes\Component;

afterEach(function () {
    Component::configureUsing(fn (Component $component) => $component);
});

it('can be configured using a callback', function () {
    expect(Component::make())
        ->getName()->toBe('Products');

    Component::configureUsing(fn (Component $component) => $component->name('Users'));

    expect(Component::make())
        ->getName()->toBe('Users');
});
