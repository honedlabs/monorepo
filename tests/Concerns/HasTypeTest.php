<?php

use Workbench\App\Attributable;
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
    expect($component->lacksType())->toBeTrue();
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
    expect($component->lacksType())->toBeTrue();
    $component->setType('Type');
    expect($component->lacksType())->toBeFalse();
});

it('evaluates the type attribute', function () {
    $component = new Attributable;
    expect($component->getType())->toBe('type');
});

it('evaluates the type attribute only as fallback', function () {
    $component = new Attributable;
    $component->setType(fn () => 'Setter');
    expect($component->getType())->toBe('Setter');
});
