<?php

use Workbench\App\Component;

it('can set strict', function () {
    $component = new Component;
    $component->setStrict(true);
    expect($component->isStrict())->toBeTrue();
});

it('prevents null values', function () {
    $component = new Component;
    $component->setStrict(null);
    expect($component->isStrict())->toBeFalse();
});

it('can set closure strict', function () {
    $component = new Component;
    $component->setStrict(fn () => true);
    expect($component->isStrict())->toBeTrue();
});

it('stricts to false', function () {
    $component = new Component;
    expect($component->isStrict())->toBeFalse();
});

it('can chain strict', function () {
    $component = new Component;
    expect($component->strict(true))->toBeInstanceOf(Component::class);
    expect($component->isStrict())->toBeTrue();
});

it('checks if strict', function () {
    $component = new Component;
    expect($component->isStrict())->toBeFalse();
    $component->setStrict(true);
    expect($component->isStrict())->toBeTrue();
});

it('checks if not strict', function () {
    $component = new Component;
    expect($component->isNotStrict())->toBeTrue();
    $component->setStrict(true);
    expect($component->isNotStrict())->toBeFalse();
});
