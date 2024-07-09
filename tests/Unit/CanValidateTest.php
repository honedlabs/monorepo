<?php

use Workbench\App\Component;

it('can set validator', function () {
    $component = new Component();
    $component->setValidator(fn (int $record) => $record > 0);
    expect($component->canValidate())->toBeTrue();
});

it('can chain validator', function () {
    $component = new Component();
    expect($component->validate(fn (int $record) => $record > 0))->toBeInstanceOf(Component::class);
    expect($component->canValidate())->toBeTrue();
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
    $component->setValidator(fn (int $record) => $record > 0);
    expect($component->canValidate())->toBeTrue();
});

it('has alias for checking validator', function () {
    $component = new Component();
    $component->setValidator(fn (int $record) => $record > 0);
    expect($component->cannotValidate())->toBeFalse();
    expect($component->canValidate())->toBeTrue();
    expect($component->hasValidator())->toBeTrue();
});

it('applies validator', function () {
    $component = new Component();
    $component->setValidator(fn (int $record) => $record > 0);
    expect($component->validateUsing(2))->toBe(true);
    expect($component->validateUsing(0))->toBe(false);
});

it('applies validator with alias', function () {
    $component = new Component();
    $component->setValidator(fn (string $record) => mb_strlen($record) > 1);
    expect($component->applyValidation('a'))->toBe(false);
    expect($component->isValid('ab'))->toBe(true);
});

it('validates true as default', function () {
    $component = new Component();
    expect($component->validateUsing(2))->toBe(true);
});
