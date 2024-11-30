<?php

use Workbench\App\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a string alias', function () {
    $this->component->setAlias($p = 'Alias');
    expect($this->component->getAlias())->toBe($p);
});

it('can set a closure alias', function () {
    $this->component->setAlias(fn () => 'Alias');
    expect($this->component->getAlias())->toBe('Alias');
});

it('prevents null values', function () {
    $this->component->setAlias(null);
    expect($this->component->missingAlias())->toBeTrue();
});

it('can chain alias', function () {
    expect($this->component->alias($p = 'Alias'))->toBeInstanceOf(Component::class);
    expect($this->component->getAlias())->toBe($p);
});

it('checks for alias', function () {
    expect($this->component->hasAlias())->toBeFalse();
    $this->component->setAlias('Alias');
    expect($this->component->hasAlias())->toBeTrue();
});

it('checks for no alias', function () {
    expect($this->component->missingAlias())->toBeTrue();
    $this->component->setAlias('Alias');
    expect($this->component->missingAlias())->toBeFalse();
});