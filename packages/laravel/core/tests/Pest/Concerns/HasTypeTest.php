<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasType;

class HasTypeComponent
{
    use HasType;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new HasTypeComponent;
});

it('has no type by default', function () {
    expect($this->component)
        ->getType()->toBeNull()
        ->hasType()->toBeFalse();
});

it('sets type', function () {
    $this->component->setType('Type');
    expect($this->component)
        ->getType()->toBe('Type')
        ->hasType()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setType('Type');
    $this->component->setType(null);
    expect($this->component)
        ->getType()->toBe('Type')
        ->hasType()->toBeTrue();
});

it('chains type', function () {
    expect($this->component->type('Type'))->toBeInstanceOf(HasTypeComponent::class)
        ->getType()->toBe('Type')
        ->hasType()->toBeTrue();
});