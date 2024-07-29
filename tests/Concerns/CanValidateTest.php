<?php

use Workbench\App\Component;

it('can set validator', function () {
    $component = new Component();
    $component->setValidate(fn (int $record) => $record > 0);
    expect($component->canValidate())->toBeTrue();
});

it('can chain validator', function () {
    $component = new Component();
    expect($component->validate(fn (int $record) => $record > 0))->toBeInstanceOf(Component::class);
    expect($component->canValidate())->toBeTrue();
});

it('can chain validator with alias', function () {
    $component = new Component();
    expect($component->validateUsing(fn (int $record) => $record > 0))->toBeInstanceOf(Component::class);
    expect($component->canValidate())->toBeTrue();
});

it('prevents null values', function () {
    $component = new Component();
    $component->setValidate(null);
    expect($component->canValidate())->toBeFalse();
});

it('defaults to no validator', function () {
    $component = new Component();
    expect($component->canValidate())->toBeFalse();
});

it('can check for no validator', function () {
    $component = new Component();
    expect($component->cannotValidate())->toBeTrue();
});

it('can check for a validator', function () {
    $component = new Component();
    $component->setValidate(fn (int $record) => $record > 0);
    expect($component->canValidate())->toBeTrue();
});

it('has alias for checking validator', function () {
    $component = new Component();
    $component->setValidate(fn (int $record) => $record > 0);
    expect($component->cannotValidate())->toBeFalse();
    expect($component->canValidate())->toBeTrue();
});

it('applies validator', function () {
    $component = new Component();
    $component->setValidate(fn (int $record) => $record > 0);
    expect($component->applyValidation(2))->toBe(true);
    expect($component->applyValidation(0))->toBe(false);
});

it('applies validator with alias', function () {
    $component = new Component();
    $component->setValidate(fn (string $record) => mb_strlen($record) > 1);
    expect($component->isValid('a'))->toBe(false);
    expect($component->isValid('ab'))->toBe(true);
});

it('validates true as default', function () {
    $component = new Component();
    expect($component->applyValidation(2))->toBe(true);
});
