<?php

use Workbench\App\Component;

it('can set a string description', function () {
    $component = new Component();
    $component->setDescription($d = 'Description');
    expect($component->getDescription())->toBe($d);
});

it('can set a closure description', function () {
    $component = new Component();
    $component->setDescription($d = fn () => 'Description');
    expect($component->getDescription())->toBe('Description');
});

it('can chain description', function () {
    $component = new Component();
    expect($component->description($d = 'Description'))->toBeInstanceOf(Component::class);
    expect($component->getDescription())->toBe($d);
});

it('checks for description', function () {
    $component = new Component();
    expect($component->hasDescription())->toBeFalse();
    $component->setDescription('Description');
    expect($component->hasDescription())->toBeTrue();
});

it('checks for no description', function () {
    $component = new Component();
    expect($component->lacksDescription())->toBeTrue();
    $component->setDescription('Description');
    expect($component->lacksDescription())->toBeFalse();
});