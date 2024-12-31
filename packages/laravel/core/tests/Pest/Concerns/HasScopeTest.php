<?php

use Honed\Core\Concerns\HasScope;

class HasScopeComponent
{
    use HasScope;
}

beforeEach(function () {
    $this->component = new HasScopeComponent;
});

it('has no scope by default', function () {
    expect($this->component)
        ->getScope()->toBeNull()
        ->hasScope()->toBeFalse();
});

it('sets scope', function () {
    $this->component->setScope('Scope');
    expect($this->component)
        ->getScope()->toBe('Scope')
        ->hasScope()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setScope('Scope');
    $this->component->setScope(null);
    expect($this->component)
        ->getScope()->toBe('Scope')
        ->hasScope()->toBeTrue();
});

it('chains scope', function () {
    expect($this->component->scope('Scope'))->toBeInstanceOf(HasScopeComponent::class)
        ->getScope()->toBe('Scope')
        ->hasScope()->toBeTrue();
});
