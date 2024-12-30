<?php

use Honed\Core\Tests\Stubs\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a string placeholder', function () {
    $this->component->setPlaceholder($p = 'Placeholder');
    expect($this->component->getPlaceholder())->toBe($p);
});

it('can set a closure placeholder', function () {
    $this->component->setPlaceholder(fn () => 'Placeholder');
    expect($this->component->getPlaceholder())->toBe('Placeholder');
});

it('prevents null values', function () {
    $this->component->setPlaceholder('Placeholder');
    $this->component->setPlaceholder(null);
    expect($this->component->getPlaceholder())->toBe('Placeholder');
});

it('can chain placeholder', function () {
    expect($this->component->placeholder($p = 'Placeholder'))->toBeInstanceOf(Component::class);
    expect($this->component->getPlaceholder())->toBe($p);
});

it('checks for placeholder', function () {
    expect($this->component->hasPlaceholder())->toBeFalse();
    $this->component->setPlaceholder('Placeholder');
    expect($this->component->hasPlaceholder())->toBeTrue();
});

it('resolves a placeholder', function () {
    expect($this->component->placeholder(fn ($record) => $record.'.'))
        ->toBeInstanceOf(Component::class)
        ->resolvePlaceholder(['record' => 'Placeholder'])->toBe('Placeholder.');
});
