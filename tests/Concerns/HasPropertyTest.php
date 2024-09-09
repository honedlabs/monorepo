<?php

use Workbench\App\Attributable;
use Workbench\App\Component;

it('can set a string property', function () {
    $component = new Component;
    $component->setProperty($n = 'Property');
    expect($component->getProperty())->toBe($n);
});

it('can set a closure property', function () {
    $component = new Component;
    $component->setProperty(fn () => 'Property');
    expect($component->getProperty())->toBe('Property');
});

it('prevents null values', function () {
    $component = new Component;
    $component->setProperty(null);
    expect($component->lacksProperty())->toBeTrue();
});

it('can set an array of properties', function () {
    $component = new Component;
    $component->setProperty($p = ['property', 'slug']);
    expect($component->getProperty())->toBe($p);
});

it('can chain property', function () {
    $component = new Component;
    expect($component->property($n = 'Property'))->toBeInstanceOf(Component::class);
    expect($component->getProperty())->toBe($n);
});

it('checks for property', function () {
    $component = new Component;
    expect($component->hasProperty())->toBeFalse();
    $component->setProperty('Property');
    expect($component->hasProperty())->toBeTrue();
});

it('checks for no property', function () {
    $component = new Component;
    expect($component->lacksProperty())->toBeTrue();
    $component->setProperty('Property');
    expect($component->lacksProperty())->toBeFalse();
});

it('checks if property is array', function () {
    $component = new Component;
    $component->setProperty(['property', 'slug']);
    expect($component->isPropertyArray())->toBeTrue();
});

it('evaluates the property attribute', function () {
    $component = new Attributable;
    expect($component->getProperty())->toBe('property');
});

it('evaluates the property attribute only as fallback', function () {
    $component = new Attributable;
    $component->setProperty(fn () => 'Setter');
    expect($component->getProperty())->toBe('Setter');
});
