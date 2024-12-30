<?php

use Workbench\App\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a string description', function () {
    $this->component->setDescription($d = 'Description');
    expect($this->component->getDescription())->toBe($d);
});

it('prevents null values', function () {
    $this->component->setDescription(null);
    expect($this->component->missingDescription())->toBeTrue();
});

it('can set a closure description', function () {
    $this->component->setDescription(fn () => 'Description');
    expect($this->component->getDescription())->toBe('Description');
});

it('can chain description', function () {
    expect($this->component->description($d = 'Description'))->toBeInstanceOf(Component::class);
    expect($this->component->getDescription())->toBe($d);
});

it('checks for description', function () {
    expect($this->component->hasDescription())->toBeFalse();
    $this->component->setDescription('Description');
    expect($this->component->hasDescription())->toBeTrue();
});

it('checks for no description', function () {
    expect($this->component->missingDescription())->toBeTrue();
    $this->component->setDescription('Description');
    expect($this->component->missingDescription())->toBeFalse();
});

it('resolves a description', function () {
    expect($this->component->description(fn ($record) => $record.'.'))
        ->toBeInstanceOf(Component::class)
        ->resolveDescription(['record' => 'Description'])->toBe('Description.');
});
