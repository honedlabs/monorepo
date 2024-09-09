<?php

use Workbench\App\Attributable;
use Workbench\App\Component;

it('can set a string name', function () {
    $component = new Component;
    $component->setName($n = 'Name');
    expect($component->getName())->toBe($n);
});

it('can set a closure name', function () {
    $component = new Component;
    $component->setName(fn () => 'Name');
    expect($component->getName())->toBe('Name');
});

it('prevents null values', function () {
    $component = new Component;
    $component->setName(null);
    expect($component->lacksName())->toBeTrue();
});

it('can chain name', function () {
    $component = new Component;
    expect($component->name($n = 'Name'))->toBeInstanceOf(Component::class);
    expect($component->getName())->toBe($n);
});

it('checks for name', function () {
    $component = new Component;
    expect($component->hasName())->toBeFalse();
    $component->setName('Name');
    expect($component->hasName())->toBeTrue();
});

it('checks for no name', function () {
    $component = new Component;
    expect($component->lacksName())->toBeTrue();
    $component->setName('Name');
    expect($component->lacksName())->toBeFalse();
});

it('converts text to a name', function () {
    $name = (new Component)->toName('A name goes here');
    expect($name)->toBe('a_name_goes_here');
});

it('evaluates the name attribute', function () {
    $component = new Attributable;
    expect($component->getName())->toBe('Name');
});