<?php

use Honed\Core\Tests\Stubs\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a string name', function () {
    $this->component->setName($n = 'Name');
    expect($this->component->getName())->toBe($n);
});

it('can set a closure name', function () {
    $this->component->setName(fn () => 'Name');
    expect($this->component->getName())->toBe('Name');
});

it('prevents null values', function () {
    $this->component->setName('Name');
    $this->component->setName(null);
    expect($this->component->getName())->toBe('Name');
});

it('can chain name', function () {
    expect($this->component->name($n = 'Name'))->toBeInstanceOf(Component::class);
    expect($this->component->getName())->toBe($n);
});

it('checks for name', function () {
    expect($this->component->hasName())->toBeFalse();
    $this->component->setName('Name');
    expect($this->component->hasName())->toBeTrue();
});

it('converts text to a name', function () {
    $name = $this->component->makeName('A name goes here');
    expect($name)->toBe('a_name_goes_here');
});

it('resolves a name', function () {
    expect($this->component->name(fn ($record) => $record.'.'))
        ->toBeInstanceOf(Component::class)
        ->resolveName(['record' => 'Name'])->toBe('Name.');
});
