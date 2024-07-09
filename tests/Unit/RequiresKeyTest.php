<?php

use Workbench\App\ConfigurableComponent;
use Conquest\Core\Exceptions\KeyDoesntExist;
use Workbench\App\Component;

it('returns key if defined', function () {
    $component = new ConfigurableComponent();
    expect($component->getKey())->toBe($component->key);
});

it('throws exception if key not defined', function () {
    $component = new ConfigurableComponent();
    unset($component->key);
    $component->getKey();
})->throws(KeyDoesntExist::class);