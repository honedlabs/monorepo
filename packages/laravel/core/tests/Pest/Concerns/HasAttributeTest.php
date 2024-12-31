<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasAttribute;

class HasAttributeComponent
{
    use HasAttribute;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new HasAttributeComponent;
});

it('has no attribute by default', function () {
    expect($this->component)
        ->getAttribute()->toBeNull()
        ->hasAttribute()->toBeFalse();
});

it('sets attribute', function () {
    $this->component->setAttribute('Attribute');
    expect($this->component)
        ->getAttribute()->toBe('Attribute')
        ->hasAttribute()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setAttribute('Attribute');
    $this->component->setAttribute(null);
    expect($this->component)
        ->getAttribute()->toBe('Attribute')
        ->hasAttribute()->toBeTrue();
});

it('chains attribute', function () {
    expect($this->component->attribute('Attribute'))->toBeInstanceOf(HasAttributeComponent::class)
        ->getAttribute()->toBe('Attribute')
        ->hasAttribute()->toBeTrue();
});

it('resolves attribute', function () {
    expect($this->component->attribute(fn ($record) => $record.'.'))
        ->toBeInstanceOf(HasAttributeComponent::class)
        ->resolveAttribute(['record' => 'Attribute'])->toBe('Attribute.')
        ->getAttribute()->toBe('Attribute.');
});