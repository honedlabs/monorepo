<?php

use Honed\Core\Concerns\HasAlias;

class HasAliasComponent
{
    use HasAlias;
}

beforeEach(function () {
    $this->component = new HasAliasComponent;
});

it('has no alias by default', function () {
    expect($this->component)
        ->getAlias()->toBeNull()
        ->hasAlias()->toBeFalse();
});

it('sets alias', function () {
    $this->component->setAlias('Alias');
    expect($this->component)
        ->getAlias()->toBe('Alias')
        ->hasAlias()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setAlias('Alias');
    $this->component->setAlias(null);
    expect($this->component)
        ->getAlias()->toBe('Alias')
        ->hasAlias()->toBeTrue();
});

it('chains alias', function () {
    expect($this->component->alias('Alias'))->toBeInstanceOf(HasAliasComponent::class)
        ->getAlias()->toBe('Alias')
        ->hasAlias()->toBeTrue();
});