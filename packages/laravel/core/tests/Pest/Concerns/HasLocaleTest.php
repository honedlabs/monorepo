<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasLocale;

class HasLocaleComponent
{
    use HasLocale;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new HasLocaleComponent;
});

it('has no locale by default', function () {
    expect($this->component)
        ->getLocale()->toBeNull()
        ->hasLocale()->toBeFalse();
});

it('sets locale', function () {
    $this->component->setLocale($p = 'Locale');
    expect($this->component)
        ->getLocale()->toBe($p)
        ->hasLocale()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setLocale('Locale');
    $this->component->setLocale(null);
    expect($this->component)
        ->getLocale()->toBe('Locale')
        ->hasLocale()->toBeTrue();
});

it('chains locale', function () {
    expect($this->component->locale($p = 'Locale'))->toBeInstanceOf(HasLocaleComponent::class)
        ->getLocale()->toBe($p)
        ->hasLocale()->toBeTrue();
});