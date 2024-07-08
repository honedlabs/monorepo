<?php

use Workbench\App\Component;

it('can set metadata', function () {
    $component = new Component();
    $component->setMetadata($m = [
        'key' => 'value',
    ]);
    expect($component->getMetadata())->toBe($m);
});

it('can set closure metadata', function () {
    $component = new Component();
    $component->setMetadata(fn () => ['key' => 'value']);
    expect($component->getMetadata())->toBe([
        'key' => 'value',
    ]);
});

it('can chain metadata', function () {
    $component = new Component();
    expect($component->metadata($m = [
        'key' => 'value',
    ]))->toBeInstanceOf(Component::class);
    expect($component->getMetadata())->toBe($m);
});

it('checks for metadata', function () {
    $component = new Component();
    expect($component->hasMetadata())->toBeFalse();
    $component->setMetadata([]);
    expect($component->hasMetadata())->toBeFalse();
    $component->setMetadata(['key' => 'value']);
    expect($component->hasMetadata())->toBeTrue();
});

it('checks for no metadata', function () {
    $component = new Component();
    expect($component->lacksMetadata())->toBeTrue();
    $component->setMetadata([]);
    expect($component->lacksMetadata())->toBeTrue();
    $component->setMetadata(['key' => 'value']);
    expect($component->lacksMetadata())->toBeFalse();
});