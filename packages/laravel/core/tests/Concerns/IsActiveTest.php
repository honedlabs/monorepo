<?php

use Workbench\App\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set active', function () {
    $this->component->setActive(true);
    expect($this->component->isActive())->toBeTrue();
});

it('prevents null values', function () {
    $this->component->setActive(null);
    expect($this->component->isActive())->toBeFalse();
});

it('can set closure active', function () {
    $this->component->setActive(fn () => true);
    expect($this->component->isActive())->toBeTrue();
});

it('defaults to false', function () {
    expect($this->component->isActive())->toBeFalse();
});

it('can chain active', function () {
    expect($this->component->active(true))->toBeInstanceOf(Component::class);
    expect($this->component->isActive())->toBeTrue();
});

it('checks if active', function () {
    expect($this->component->isActive())->toBeFalse();
    expect($this->component->isNotActive())->toBeTrue();
    $this->component->setActive('Active');
    expect($this->component->isActive())->toBeTrue();
    expect($this->component->isNotActive())->toBeFalse();
});
