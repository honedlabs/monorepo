<?php

use Honed\Core\Tests\Stubs\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a string type', function () {
    $this->component->setType($t = 'Type');
    expect($this->component->getType())->toBe($t);
});

it('can set a closure type', function () {
    $this->component->setType(fn () => 'Type');
    expect($this->component->getType())->toBe('Type');
});

it('prevents null values', function () {
    $this->component->setType('Type');
    $this->component->setType(null);
    expect($this->component->getType())->toBe('Type');
});

it('can chain type', function () {
    expect($this->component->type($t = 'Type'))->toBeInstanceOf(Component::class);
    expect($this->component->getType())->toBe($t);
});

it('checks for type', function () {
    expect($this->component->hasType())->toBeFalse();
    $this->component->setType('Type');
    expect($this->component->hasType())->toBeTrue();
});

it('resolves a type', function () {
    expect($this->component->type(fn ($record) => $record.'.'))
        ->toBeInstanceOf(Component::class)
        ->resolveType(['record' => 'Type'])->toBe('Type.');
});
