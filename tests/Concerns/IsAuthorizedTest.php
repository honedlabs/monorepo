<?php

use Workbench\App\Component;

it('can chain authorization', function () {
    $component = new Component;
    expect($component->authorize(false))->toBeInstanceOf(Component::class);
    expect($component->isAuthorized())->toBeFalse();
});

it('can chain authorisation', function () {
    $component = new Component;
    expect($component->authorise(false))->toBeInstanceOf(Component::class);
    expect($component->isAuthorised())->toBeFalse();
});

it('prevents null values for authorization', function () {
    $component = new Component;
    $component->setAuthorize(null);
    expect($component->isAuthorized())->toBeTrue();
});

it('prevents null values for authorisation', function () {
    $component = new Component;
    $component->setAuthorise(null);
    expect($component->isAuthorised())->toBeTrue();
});

it('can set boolean authorization', function () {
    $component = new Component;
    $component->setAuthorize(false);
    expect($component->isAuthorized())->toBeFalse();
});

it('can set boolean authorisation', function () {
    $component = new Component;
    $component->setAuthorise(false);
    expect($component->isAuthorised())->toBeFalse();
});

it('can set closure authorization', function () {
    $component = new Component;
    $component->setAuthorize(fn () => 2 == 3);
    expect($component->isAuthorized())->toBeFalse();
});

it('can set closure authorisation', function () {
    $component = new Component;
    $component->setAuthorise(fn () => 2 == 3);
    expect($component->isAuthorised())->toBeFalse();
});

it('defaults authorisation to true', function () {
    $component = new Component;
    expect($component->isAuthorized())->toBeTrue();
    expect($component->isAuthorised())->toBeTrue();
});

it('checks if not authorized', function () {
    $component = new Component;
    expect($component->isNotAuthorized())->toBeFalse();
    $component->setAuthorize(false);
    expect($component->isNotAuthorized())->toBeTrue();
});

it('checks if not authorised', function () {
    $component = new Component;
    expect($component->isNotAuthorised())->toBeFalse();
    $component->setAuthorise(false);
    expect($component->isNotAuthorised())->toBeTrue();
});
