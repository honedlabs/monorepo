<?php

use Conquest\Core\Exceptions\MissingRequiredAttributeException;
use Workbench\App\ConfigurableComponent;
use Workbench\App\KeyComponent;

it('returns key if defined', function () {
    $component = new ConfigurableComponent();
    expect($component->getKey())->toBe($component->key);
});

it('throws exception if key not defined', function () {
    $component = new ConfigurableComponent();
    unset($component->key);
    $component->getKey();
})->throws(MissingRequiredAttributeException::class);

it('returns key if method defined', function () {
    $component = new KeyComponent();
    expect($component->getKey())->toBe('id');
});