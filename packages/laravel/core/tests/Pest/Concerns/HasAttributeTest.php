<?php

use Honed\Core\Tests\Stubs\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a string attribute', function () {
    $this->component->setAttribute($n = 'Attribute');
    expect($this->component->getAttribute())->toBe($n);
});

it('can set a closure attribute', function () {
    $this->component->setAttribute(fn () => 'Attribute');
    expect($this->component->getAttribute())->toBe('Attribute');
});

it('prevents null values', function () {
    $this->component->setAttribute(null);
    expect($this->component->hasAttribute())->toBeFalse();
});

it('can chain attribute', function () {
    expect($this->component->attribute($n = 'Attribute'))->toBeInstanceOf(Component::class);
    expect($this->component->getAttribute())->toBe($n);
});

it('checks for attribute', function () {
    expect($this->component->hasAttribute())->toBeFalse();
    $this->component->setAttribute('Attribute');
    expect($this->component->hasAttribute())->toBeTrue();
});

it('resolves an attribute', function () {
    expect($this->component->attribute(fn ($record) => $record.'.'))
        ->toBeInstanceOf(Component::class)
        ->resolveAttribute(['record' => 'Attribute'])->toBe('Attribute.');

    expect($this->component->getAttribute())->toBe('Attribute.');
});
