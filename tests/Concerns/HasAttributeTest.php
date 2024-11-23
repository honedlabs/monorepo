<?php

use Workbench\App\Component;

it('can set a string attribute', function () {
    $component = new Component;
    $component->setAttribute($n = 'Attribute');
    expect($component->getAttribute())->toBe($n);
});

it('can set a closure attribute', function () {
    $component = new Component;
    $component->setAttribute(fn () => 'Attribute');
    expect($component->getAttribute())->toBe('Attribute');
});

it('prevents null values', function () {
    $component = new Component;
    $component->setAttribute(null);
    expect($component->missingAttribute())->toBeTrue();
});

it('can chain attribute', function () {
    $component = new Component;
    expect($component->attribute($n = 'Attribute'))->toBeInstanceOf(Component::class);
    expect($component->getAttribute())->toBe($n);
});

it('checks for attribute', function () {
    $component = new Component;
    expect($component->hasAttribute())->toBeFalse();
    $component->setAttribute('Attribute');
    expect($component->hasAttribute())->toBeTrue();
});

it('checks for no attribute', function () {
    $component = new Component;
    expect($component->missingAttribute())->toBeTrue();
    $component->setAttribute('Attribute');
    expect($component->missingAttribute())->toBeFalse();
});
