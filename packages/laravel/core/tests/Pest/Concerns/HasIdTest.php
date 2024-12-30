<?php

use Honed\Core\Tests\Stubs\Component;

it('can set an id', function () {
    $component = new Component;
    $component->setId($i = 1);
    expect($component->getId())->toBe($i);
});

it('prevents null values', function () {
    $component = new Component;
    $component->setId(null);
    expect($component->hasId())->toBeFalse();
});

it('can chain id', function () {
    $component = new Component;
    expect($component->id($i = 'id'))->toBeInstanceOf(Component::class);
    expect($component->getId())->toBe($i);
});

it('checks for id', function () {
    $component = new Component;
    expect($component->hasId())->toBeFalse();
    $component->setId('Id');
    expect($component->hasId())->toBeTrue();
});

it('can generate an id', function () {
    $component = new Component;
    expect($id = $component->generateId())->toBeString();
    expect($component->getId())->toBe($id);
});

it('generates an id if none provided', function () {
    $component = new Component;
    expect($component->getId())->toBeString();
});
