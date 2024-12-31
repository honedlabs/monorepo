<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasLocale;
use Illuminate\Support\Facades\App;

class HasLocaleComponent
{
    use HasLocale;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new HasLocaleComponent;
});

it('has app locale by default', function () {
    expect($this->component)
        ->getLocale()->toBe(App::getLocale())
        ->hasLocale()->toBeTrue();
});

it('sets locale', function () {
    $this->component->setLocale('Locale');
    expect($this->component)
        ->getLocale()->toBe('Locale')
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
    expect($this->component->locale('Locale'))->toBeInstanceOf(HasLocaleComponent::class)
        ->getLocale()->toBe('Locale')
        ->hasLocale()->toBeTrue();
});
