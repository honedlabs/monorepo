<?php

use Honed\Core\Tests\Stubs\Component;

it('can set key', function () {
    $component = new Component;
    $component->setKey(true);
    expect($component->isKey())->toBeTrue();
});

it('prevents null values', function () {
    $component = new Component;
    $component->setKey(null);
    expect($component->isKey())->toBeFalse();
});

it('can set closure key', function () {
    $component = new Component;
    $component->setKey(fn () => true);
    expect($component->isKey())->toBeTrue();
});

it('defaults to false', function () {
    $component = new Component;
    expect($component->isKey())->toBeFalse();
});

it('can chain key', function () {
    $component = new Component;
    expect($component->key(true))->toBeInstanceOf(Component::class);
    expect($component->isKey())->toBeTrue();
});

it('checks if key', function () {
    $component = new Component;
    expect($component->isKey())->toBeFalse();
    $component->setKey('Key');
    expect($component->isKey())->toBeTrue();
});

it('checks if not key', function () {
    $component = new Component;
    expect($component->isNotKey())->toBeTrue();
    $component->setKey('Key');
    expect($component->isNotKey())->toBeFalse();
});
