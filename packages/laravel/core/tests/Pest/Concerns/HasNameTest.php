<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasName;

class HasNameComponent
{
    use HasName;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new HasNameComponent;
});

it('has no name by default', function () {
    expect($this->component)
        ->getName()->toBeNull()
        ->hasName()->toBeFalse();
});

it('sets name', function () {
    $this->component->setName('Name');
    expect($this->component)
        ->getName()->toBe('Name')
        ->hasName()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setName('Name');
    $this->component->setName(null);
    expect($this->component)
        ->getName()->toBe('Name')
        ->hasName()->toBeTrue();
});

it('chains name', function () {
    expect($this->component->name('Name'))->toBeInstanceOf(HasNameComponent::class)
        ->getName()->toBe('Name')
        ->hasName()->toBeTrue();
});

it('resolves name', function () {
    expect($this->component->name(fn ($record) => $record.'.'))
        ->toBeInstanceOf(HasNameComponent::class)
        ->resolveName(['record' => 'Name'])->toBe('Name.')
        ->getName()->toBe('Name.');
});

it('makes a name', function () {
    expect($this->component->makeName('New label'))->toBe('new_label');
});
