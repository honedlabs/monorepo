<?php

use Honed\Core\Identifier\Concerns\HasId;

class HasIdComponent
{
    use HasId;
}

beforeEach(function () {
    $this->component = new HasIdComponent;
});

it('generates an id by default', function () {
    expect($this->component)
        ->getId()->not->toBeNull()
        ->hasId()->toBeTrue();
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
