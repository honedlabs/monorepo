<?php

use Workbench\App\Component;

it('can set a string type', function () {
    $component = new Component;
    $component->setType($t = 'Type');
    expect($component->getType())->toBe($t);
});

it('can set a closure type', function () {
    $component = new Component;
    $component->setType(fn () => 'Type');
    expect($component->getType())->toBe('Type');
});

it('prevents null values', function () {
    $component = new Component;
    $component->setType(null);
    expect($component->missingType())->toBeTrue();
});

it('can chain type', function () {
    $component = new Component;
    expect($component->type($t = 'Type'))->toBeInstanceOf(Component::class);
    expect($component->getType())->toBe($t);
});

it('checks for type', function () {
    $component = new Component;
    expect($component->hasType())->toBeFalse();
    $component->setType('Type');
    expect($component->hasType())->toBeTrue();
});

it('checks for no type', function () {
    $component = new Component;
    expect($component->missingType())->toBeTrue();
    $component->setType('Type');
    expect($component->missingType())->toBeFalse();
});