<?php

use Workbench\App\Attributable;
use Workbench\App\Component;

it('can set a string placeholder', function () {
    $component = new Component;
    $component->setPlaceholder($p = 'Placeholder');
    expect($component->getPlaceholder())->toBe($p);
});

it('can set a closure placeholder', function () {
    $component = new Component;
    $component->setPlaceholder(fn () => 'Placeholder');
    expect($component->getPlaceholder())->toBe('Placeholder');
});

it('prevents null values', function () {
    $component = new Component;
    $component->setPlaceholder(null);
    expect($component->lacksPlaceholder())->toBeTrue();
});

it('can chain placeholder', function () {
    $component = new Component;
    expect($component->placeholder($p = 'Placeholder'))->toBeInstanceOf(Component::class);
    expect($component->getPlaceholder())->toBe($p);
});

it('checks for placeholder', function () {
    $component = new Component;
    expect($component->hasPlaceholder())->toBeFalse();
    $component->setPlaceholder('Placeholder');
    expect($component->hasPlaceholder())->toBeTrue();
});

it('checks for no placeholder', function () {
    $component = new Component;
    expect($component->lacksPlaceholder())->toBeTrue();
    $component->setPlaceholder('Placeholder');
    expect($component->lacksPlaceholder())->toBeFalse();
});

it('evaluates the placeholder attribute', function () {
    $component = new Attributable;
    expect($component->getPlaceholder())->toBe('Placeholder');
});

it('evaluates the placeholder attribute only as fallback', function () {
    $component = new Attributable;
    $component->setPlaceholder(fn () => 'Setter');
    expect($component->getPlaceholder())->toBe('Setter');
});
