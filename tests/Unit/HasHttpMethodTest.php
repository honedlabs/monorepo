<?php

use Illuminate\Http\Request;
use Workbench\App\Component;

it('can set a method', function () {
    $component = new Component();
    $component->setMethod('GET');
    expect($component->getMethod())->toBe(Request::METHOD_GET);
});

it('can chain method', function () {
    $component = new Component();
    expect($component->method(Request::METHOD_GET))->toBeInstanceOf(Component::class);
    expect($component->getMethod())->toBe(Request::METHOD_GET);
});

it('checks for method', function () {
    $component = new Component();
    expect($component->hasMethod())->toBeFalse();
    $component->setMethod(Request::METHOD_GET);
    expect($component->hasMethod())->toBeTrue();
});

it('checks for no method', function () {
    $component = new Component();
    expect($component->lacksMethod())->toBeTrue();
    $component->setMethod(Request::METHOD_GET);
    expect($component->lacksMethod())->toBeFalse();
});

it('uses get method', function () {
    $component = new Component();
    expect($component->useGet())->toBeInstanceOf(Component::class);
    expect($component->isGet())->toBeTrue();
});

it('uses post method', function () {
    $component = new Component();
    expect($component->usePost())->toBeInstanceOf(Component::class);
    expect($component->isPost())->toBeTrue();
});

it('uses put method', function () {
    $component = new Component();
    expect($component->usePut())->toBeInstanceOf(Component::class);
    expect($component->isPut())->toBeTrue();
});

it('uses patch method', function () {
    $component = new Component();
    expect($component->usePatch())->toBeInstanceOf(Component::class);
    expect($component->isPatch())->toBeTrue();
});

it('uses delete method', function () {
    $component = new Component();
    expect($component->useDelete())->toBeInstanceOf(Component::class);
    expect($component->isDelete())->toBeTrue();
});

it('uses head method', function () {
    $component = new Component();
    expect($component->useHead())->toBeInstanceOf(Component::class);
    expect($component->isHead())->toBeTrue();
});

it('uses options method', function () {
    $component = new Component();
    expect($component->useOptions())->toBeInstanceOf(Component::class);
    expect($component->isOptions())->toBeTrue();
});

it('uses method', function () {
    $component = new Component();
    expect($component->useMethod(Request::METHOD_GET))->toBeInstanceOf(Component::class);
    expect($component->isGet())->toBeTrue();
});

it('only allows for valid methods', function () {
    $component = new Component();
    $component->setMethod('INVALID');
})->throws(InvalidArgumentException::class);

it('allows for case insensitive methods', function () {
    $component = new Component();
    $component->setMethod('get');
    expect($component->isGet())->toBeTrue();
});