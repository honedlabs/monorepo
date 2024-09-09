<?php

use Workbench\App\Attributable;
use Workbench\App\Component;

it('can set a string description', function () {
    $component = new Component;
    $component->setDescription($d = 'Description');
    expect($component->getDescription())->toBe($d);
});

it('prevents null values', function () {
    $component = new Component;
    $component->setDescription(null);
    expect($component->lacksDescription())->toBeTrue();
});

it('can set a closure description', function () {
    $component = new Component;
    $component->setDescription(fn () => 'Description');
    expect($component->getDescription())->toBe('Description');
});

it('can chain description', function () {
    $component = new Component;
    expect($component->description($d = 'Description'))->toBeInstanceOf(Component::class);
    expect($component->getDescription())->toBe($d);
});

it('checks for description', function () {
    $component = new Component;
    expect($component->hasDescription())->toBeFalse();
    $component->setDescription('Description');
    expect($component->hasDescription())->toBeTrue();
});

it('checks for no description', function () {
    $component = new Component;
    expect($component->lacksDescription())->toBeTrue();
    $component->setDescription('Description');
    expect($component->lacksDescription())->toBeFalse();
});

it('evaluates the description attribute', function () {
    $component = new Attributable;
    expect($component->getDescription())->toBe('Description');
});

it('evaluates the description attribute only as fallback', function () {
    $component = new Attributable;
    $component->setDescription(fn () => 'Setter');
    expect($component->getDescription())->toBe('Setter');
});
