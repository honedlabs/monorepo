<?php

use Workbench\App\Component;

it('can set blank', function () {
    $component = new Component();
    $component->setBlank(true);
    expect($component->isBlank())->toBeTrue();
});

it('prevents null values', function () {
    $component = new Component();
    $component->setBlank(null);
    expect($component->isBlank())->toBeFalse();
});

it('can set closure blank', function () {
    $component = new Component();
    $component->setBlank(fn () => true);
    expect($component->isBlank())->toBeTrue();
});

it('blanks to false', function () {
    $component = new Component();
    expect($component->isBlank())->toBeFalse();
});

it('can chain blank', function () {
    $component = new Component();
    expect($component->blank(true))->toBeInstanceOf(Component::class);
    expect($component->isBlank())->toBeTrue();
});

it('checks if blank', function () {
    $component = new Component();
    expect($component->isBlank())->toBeFalse();
    $component->setBlank('Blank');
    expect($component->isBlank())->toBeTrue();
});

it('checks if not blank', function () {
    $component = new Component();
    expect($component->isNotBlank())->toBeTrue();
    $component->setBlank('Blank');
    expect($component->isNotBlank())->toBeFalse();
});
