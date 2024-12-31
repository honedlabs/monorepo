<?php

use Honed\Core\Tests\Stubs\ConfigurableComponent;

it('configures primitive', function () {
    $component = new ConfigurableComponent;
    $component->configure();
    expect($component->getType())->toBe(ConfigurableComponent::SETUP);
});

it('makes primitive and configures', function () {
    expect($c = ConfigurableComponent::make())->toBeInstanceOf(ConfigurableComponent::class);
    expect($c->getType())->toBe(ConfigurableComponent::SETUP);
});

it('can be made to array', function () {
    $component = new ConfigurableComponent;
    expect($component->toArray())->toBe([
        'key' => $component->getKey(),
        'type' => $component->getType(),
    ]);
});

it('serializes to json using array', function () {
    $component = new ConfigurableComponent;
    expect($component->jsonSerialize())->toBe($component->toArray());
});

it('can globally configure', function () {
    ConfigurableComponent::configureUsing(function ($component) {
        $component->key = 'configured';
    });

    $component = new ConfigurableComponent;
    expect($component->getKey())->toBe('configured');
});
