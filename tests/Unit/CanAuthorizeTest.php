<?php

use Workbench\App\Component;

it('can chain authorization', function () {
    $component = new Component();
    expect($component->authorize(false))->toBeInstanceOf(Component::class);
    expect($component->authorized())->toBeFalse();
});

it('can chain authorisation', function () {
    $component = new Component();
    expect($component->authorise(false))->toBeInstanceOf(Component::class);
    expect($component->authorised())->toBeFalse();
});

it('can set boolean authorization', function () {
    $component = new Component();
    $component->setAuthorize(false);
    expect($component->authorized())->toBeFalse();
});

it('can set closure authorization', function () {
    $component = new Component();
    $component->setAuthorize(fn () => 2 == 3);
    expect($component->authorized())->toBeFalse();
});

it('defaults authorisation to true', function () {
    $component = new Component();
    expect($component->authorized())->toBeTrue();
});

it('has alias for authorisation checking', function () {
    $component = (new Component())->authorise(false);
    expect($component->authorized())->toBeFalse();
    expect($component->authorised())->toBeFalse();
    expect($component->isAuthorised())->toBeFalse();
    expect($component->isAuthorized())->toBeFalse();
});

it('has alias for authorisation negation', function () {
    $component = (new Component())->authorise(false);
    expect($component->notAuthorized())->toBeTrue();
    expect($component->notAuthorised())->toBeTrue();
    expect($component->isNotAuthorised())->toBeTrue();
    expect($component->isNotAuthorized())->toBeTrue();
});
