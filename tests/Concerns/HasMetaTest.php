<?php

use Workbench\App\Component;

it('can set meta', function () {
    $component = new Component;
    $component->setMeta($m = [
        'key' => 'value',
    ]);
    expect($component->getMeta())->toBe($m);
});

it('can set closure meta', function () {
    $component = new Component;
    $component->setMeta(fn () => ['key' => 'value']);
    expect($component->getMeta())->toBe([
        'key' => 'value',
    ]);
});

it('prevents null values', function () {
    $component = new Component;
    $component->setMeta(null);
    expect($component->lacksMeta())->toBeTrue();
});

it('can chain meta', function () {
    $component = new Component;
    expect($component->meta($m = [
        'key' => 'value',
    ]))->toBeInstanceOf(Component::class);
    expect($component->getMeta())->toBe($m);
});

it('checks for meta', function () {
    $component = new Component;
    expect($component->hasMeta())->toBeFalse();
    $component->setMeta([]);
    expect($component->hasMeta())->toBeFalse();
    $component->setMeta(['key' => 'value']);
    expect($component->hasMeta())->toBeTrue();
});

it('checks for no meta', function () {
    $component = new Component;
    expect($component->lacksMeta())->toBeTrue();
    $component->setMeta([]);
    expect($component->lacksMeta())->toBeTrue();
    $component->setMeta(['key' => 'value']);
    expect($component->lacksMeta())->toBeFalse();
});
