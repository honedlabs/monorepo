<?php

use Honed\Core\Identifier\Concerns\HasId;

class HasIdComponent
{
    use HasId;
}

beforeEach(function () {
    $this->component = new HasIdComponent;
});

it('has no id by default', function () {
    expect($this->component)
        ->getId()->toBeNull()
        ->hasId()->toBeFalse();
});

it('sets id', function () {
    $this->component->setId('Id');
    expect($this->component)
        ->getId()->toBe('Id')
        ->hasId()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setId('Id');
    $this->component->setId(null);
    expect($this->component)
        ->getId()->toBe('Id')
        ->hasId()->toBeTrue();
});

it('chains id', function () {
    expect($this->component->id('Id'))->toBeInstanceOf(HasIdComponent::class)
        ->getId()->toBe('Id')
        ->hasId()->toBeTrue();
});

it('resolves id', function () {
    expect($this->component->id(fn ($record) => $record.'.'))
        ->toBeInstanceOf(HasIdComponent::class)
        ->resolveId(['record' => 'Id'])->toBe('Id.')
        ->getId()->toBe('Id.');
});