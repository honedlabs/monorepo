<?php

use Workbench\App\Component;
use Illuminate\Http\Request;

it('can set a route', function () {
    $component = new Component;
    $component->setRoute($r = '/');
    expect($component->getRoute())->toBe($r);
});

it('can chain route', function () {
    $component = new Component;
    expect($component->route($r = '/'))->toBeInstanceOf(Component::class);
    expect($component->getRoute())->toBe($r);
    expect($component->isRoutable())->toBeTrue();
    expect($component->isNotRoutable())->toBeFalse();
});

it('prevents null values for route', function () {
    $component = new Component;
    $component->setRoute(null);
    expect($component->isNotRoutable())->toBeTrue();
    expect($component->isRoutable())->toBeFalse();
});

it('checks for route', function () {
    $component = new Component;
    expect($component->isRoutable())->toBeFalse();
    $component->setRoute('/');
    expect($component->isRoutable())->toBeTrue();
});

it('checks for no route', function () {
    $component = new Component;
    expect($component->isNotRoutable())->toBeTrue();
    $component->setRoute('/');
    expect($component->isNotRoutable())->toBeFalse();
});

it('can resolve a route', function () {
    $component = new Component;
    $component->setRoute($r = '/home');
    expect($component->getRoute())->toBe(url($r));
});

it('can set a method', function () {
    $component = new Component;
    $component->setMethod('GET');
    expect($component->getMethod())->toBe(Request::METHOD_GET);
});

it('prevents null values for method with a default', function () {
    $component = new Component;
    $component->setMethod(null);
    expect($component->getMethod())->toBe(Request::METHOD_GET);
});

it('can chain method', function () {
    $component = new Component;
    expect($component->method(Request::METHOD_GET))->toBeInstanceOf(Component::class);
    expect($component->getMethod())->toBe(Request::METHOD_GET);
});

it('checks for method', function () {
    $component = new Component;
    expect($component->hasMethod())->toBeFalse();
    $component->setMethod(Request::METHOD_GET);
    expect($component->getMethod())->toBe(Request::METHOD_GET);
});

it('uses get method', function () {
    $component = new Component;
    expect($component->get())->toBeInstanceOf(Component::class);
    expect($component->getMethod())->toBe(Request::METHOD_GET);
});

it('uses post method', function () {
    $component = new Component;
    expect($component->post())->toBeInstanceOf(Component::class);
    expect($component->getMethod())->toBe(Request::METHOD_POST);
});

it('uses put method', function () {
    $component = new Component;
    expect($component->put())->toBeInstanceOf(Component::class);
    expect($component->getMethod())->toBe(Request::METHOD_PUT);
});

it('uses patch method', function () {
    $component = new Component;
    expect($component->patch())->toBeInstanceOf(Component::class);
    expect($component->getMethod())->toBe(Request::METHOD_PATCH);
});

it('uses delete method', function () {
    $component = new Component;
    expect($component->delete())->toBeInstanceOf(Component::class);
    expect($component->getMethod())->toBe(Request::METHOD_DELETE);
});


it('uses method', function () {
    $component = new Component;
    expect($component->method(Request::METHOD_GET))->toBeInstanceOf(Component::class);
    expect($component->getMethod())->toBe(Request::METHOD_GET);
});

it('only allows for valid methods', function () {
    $component = new Component;
    $component->setMethod('INVALID');
})->throws(InvalidArgumentException::class);

it('allows for case insensitive methods', function () {
    $component = new Component;
    $component->setMethod('get');
    expect($component->getMethod())->toBe(Request::METHOD_GET);
});
