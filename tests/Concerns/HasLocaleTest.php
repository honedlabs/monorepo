<?php

use Honed\Core\Concerns\HasLocale;
use Illuminate\Support\Facades\App;

class LocaleComponent
{
    use HasLocale;
}

beforeEach(function () {
    $this->component = new LocaleComponent();
});

it('has app locale by default', function () {
    expect($this->component->hasLocale())->toBeFalse();
    expect($this->component->missingLocale())->toBeTrue();
    expect($this->component->getLocale())->toBe(App::getLocale());
});

it('can set a locale', function () {
    expect($this->component->locale('au'))->toBeInstanceOf(LocaleComponent::class)
        ->getLocale()->toBe('au');
});

it('can be set using setter', function () {
    $this->component->setLocale('au');
    expect($this->component->getLocale())->toBe('au');
});

it('does not accept null values', function () {
    $this->component->setLocale('au');
    $this->component->setLocale(null);
    expect($this->component->getLocale())->toBe('au');
});

