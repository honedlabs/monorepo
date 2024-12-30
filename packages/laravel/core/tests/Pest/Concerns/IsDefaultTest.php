<?php

use Honed\Core\Tests\Stubs\Component;

it('can set default', function () {
    $component = new Component;
    $component->setDefault(true);
    expect($component->isDefault())->toBeTrue();
});

it('prevents null values', function () {
    $component = new Component;
    $component->setDefault(null);
    expect($component->isDefault())->toBeFalse();
});

it('can set closure default', function () {
    $component = new Component;
    $component->setDefault(fn () => true);
    expect($component->isDefault())->toBeTrue();
});

it('defaults to false', function () {
    $component = new Component;
    expect($component->isDefault())->toBeFalse();
});

it('can chain default', function () {
    $component = new Component;
    expect($component->default(true))->toBeInstanceOf(Component::class);
    expect($component->isDefault())->toBeTrue();
});

it('checks if default', function () {
    $component = new Component;
    expect($component->isDefault())->toBeFalse();
    $component->setDefault(true);
    expect($component->isDefault())->toBeTrue();
});

it('checks if not default', function () {
    $component = new Component;
    expect($component->isNotDefault())->toBeTrue();
    $component->setDefault(true);
    expect($component->isNotDefault())->toBeFalse();
});
