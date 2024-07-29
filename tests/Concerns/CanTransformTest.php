<?php

use Workbench\App\Component;

it('can set transformation', function () {
    $component = new Component;
    $component->setTransform(fn (int $record) => $record * 2);
    expect($component->canTransform())->toBeTrue();
});

it('can chain transformation', function () {
    $component = new Component;
    expect($component->transform(fn (int $record) => $record * 2))->toBeInstanceOf(Component::class);
    expect($component->canTransform())->toBeTrue();
});

it('can chain transformation with alias', function () {
    $component = new Component;
    expect($component->transformUsing(fn (int $record) => $record * 2))->toBeInstanceOf(Component::class);
    expect($component->canTransform())->toBeTrue();
});

it('prevents null values', function () {
    $component = new Component;
    $component->setTransform(null);
    expect($component->canTransform())->toBeFalse();
});

it('defaults to no transformation', function () {
    $component = new Component;
    expect($component->canTransform())->toBeFalse();
});

it('can check for no transformation', function () {
    $component = new Component;
    expect($component->cannotTransform())->toBeTrue();
});

it('can check for a transformation', function () {
    $component = new Component;
    $component->setTransform(fn (int $record) => $record * 2);
    expect($component->canTransform())->toBeTrue();
});

it('has alias for checking transformation', function () {
    $component = new Component;
    $component->setTransform(fn (int $record) => $record * 2);
    expect($component->cannotTransform())->toBeFalse();
    expect($component->canTransform())->toBeTrue();
});

it('applies transformation with alias', function () {
    $component = new Component;
    $component->setTransform(fn (string $record) => mb_strtoupper($record));
    expect($component->applyTransform('a'))->toBe('A');
});

it('returns original value if no transformation', function () {
    $component = new Component;
    expect($component->applyTransform(2))->toBe(2);
});
