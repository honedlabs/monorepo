<?php

use Workbench\App\Component;

it('can set a route', function () {
    $component = new Component();
    $component->setRoute($r = '/');
    expect($component->getRoute())->toBe($r);
});

it('can chain route', function () {
    $component = new Component();
    expect($component->route($r = '/'))->toBeInstanceOf(Component::class);
    expect($component->getRoute())->toBe($r);
});

it('checks for route', function () {
    $component = new Component();
    expect($component->hasRoute())->toBeFalse();
    $component->setRoute('/');
    expect($component->hasRoute())->toBeTrue();
});

it('checks for no route', function () {
    $component = new Component();
    expect($component->lacksRoute())->toBeTrue();
    $component->setRoute('/');
    expect($component->lacksRoute())->toBeFalse();
});

it('can resolve a route', function () {
    $component = new Component();
    $component->setRoute($r = '/home');
    $component->resolveRoute();
    expect($component->getResolvedRoute())->toBe($r);
});

// it('can resolve a named route', function () {
//     $component = new Component();
//     $component->setRoute('home');
//     $component->resolveRoute();
//     expect($component->getResolvedRoute())->toBe(route('home'));
// });