<?php

use Workbench\App\Component;

it('can set default', function () {
    $component = new Component();
    $component->setDefault(true);
    expect($component->isDefault())->toBeTrue();
});

it('can set closure default', function () {
    $component = new Component();
    $component->setDefault(fn () => true);
    expect($component->isDefault())->toBeTrue();
});

it('defaults to false', function () {
    $component = new Component();
    expect($component->isDefault())->toBeFalse();
});

it('can chain default', function () {
    $component = new Component();
    expect($component->default(true))->toBeInstanceOf(Component::class);
    expect($component->isDefault())->toBeTrue();
});

it('checks if default', function () {
    $component = new Component();
    expect($component->isDefault())->toBeFalse();
    $component->setDefault('Default');
    expect($component->isDefault())->toBeTrue();
});

it('checks if not default', function () {
    $component = new Component();
    expect($component->isNotDefault())->toBeTrue();
    $component->setDefault('Default');
    expect($component->isNotDefault())->toBeFalse();
});
