<?php

use Workbench\App\Component;

it('can set active', function () {
    $component = new Component();
    $component->setActive(true);
    expect($component->isActive())->toBeTrue();
});

it('can set closure active', function () {
    $component = new Component();
    $component->setActive(fn () => true);
    expect($component->isActive())->toBeTrue();
});

it('defaults to false', function () {
    $component = new Component();
    expect($component->isActive())->toBeFalse();
});

it('can chain active', function () {
    $component = new Component();
    expect($component->active(true))->toBeInstanceOf(Component::class);
    expect($component->isActive())->toBeTrue();
});

it('checks if active', function () {
    $component = new Component();
    expect($component->isActive())->toBeFalse();
    $component->setActive('Active');
    expect($component->isActive())->toBeTrue();
});

it('checks if not active', function () {
    $component = new Component();
    expect($component->isNotActive())->toBeTrue();
    $component->setActive('Active');
    expect($component->isNotActive())->toBeFalse();
});
