<?php

use Workbench\App\Component;
use Illuminate\Http\Request;


beforeEach(function () {
    $this->component = new Component;
});

it('can set a route', function () {
    $this->component->route($r = '/');
    expect($this->component->getRoute())->toBe(url($r));
});

it('can chain route', function () {
    expect($this->component->route($r = '/'))->toBeInstanceOf(Component::class);
    expect($this->component->getRoute())->toBe(url($r));
    expect($this->component->isRoutable())->toBeTrue();
    expect($this->component->isNotRoutable())->toBeFalse();
});

it('does not allow retrieval of route if not set', function () {
    expect($this->component->getRoute())->toBeNull();
});

it('prevents null values for route', function () {
    $this->component->setRoute(null);
    expect($this->component->isNotRoutable())->toBeTrue();
    expect($this->component->isRoutable())->toBeFalse();
});

it('checks for route', function () {
    expect($this->component->isRoutable())->toBeFalse();
    $this->component->route('/');
    expect($this->component->isRoutable())->toBeTrue();
});

it('checks for no route', function () {
    expect($this->component->isNotRoutable())->toBeTrue();
    $this->component->route('/');
    expect($this->component->isNotRoutable())->toBeFalse();
});

it('can resolve a route', function () {
    $this->component->route($r = '/home');
    expect($this->component->getRoute())->toBe(url($r));
});

it('can resolve a closure route', function () {
    expect($this->component->route(fn ($p) => "/home/$p"))->toBeInstanceOf(Component::class);
    expect($this->component->getRoute('id'))->toBe(url('/home/id'));
});

it('can resolve a named route with parameters', function () {
    expect($this->component->route('lang', 'en'))->toBeInstanceOf(Component::class);
    expect($this->component->getRoute())->toBe(url('/lang/en'));
});

it('can resolve a named route with overriding parameters', function () {
    expect($this->component->route('lang'))->toBeInstanceOf(Component::class);
    expect($this->component->getRoute('en'))->toBe(url('/lang/en'));
});

it('can replace key value pairs in a route', function () {
    expect($this->component->route('/home/:id/:name'))->toBeInstanceOf(Component::class);
    expect($this->component->getRoute(['id' => '1', 'name' => 'John']))->toBe(url('/home/1/John'));
});

it('can set a method', function () {
    $this->component->setMethod('GET');
    expect($this->component->getMethod())->toBe(Request::METHOD_GET);
});

it('prevents null values for method with a default', function () {
    $this->component->setMethod(null);
    expect($this->component->getMethod())->toBe(Request::METHOD_GET);
});

it('can chain method', function () {
    expect($this->component->method(Request::METHOD_GET))->toBeInstanceOf(Component::class);
    expect($this->component->getMethod())->toBe(Request::METHOD_GET);
});

it('uses get method', function () {
    expect($this->component->get())->toBeInstanceOf(Component::class);
    expect($this->component->getMethod())->toBe(Request::METHOD_GET);
});

it('uses post method', function () {
    expect($this->component->post())->toBeInstanceOf(Component::class);
    expect($this->component->getMethod())->toBe(Request::METHOD_POST);
});

it('uses put method', function () {
    expect($this->component->put())->toBeInstanceOf(Component::class);
    expect($this->component->getMethod())->toBe(Request::METHOD_PUT);
});

it('uses patch method', function () {
    expect($this->component->patch())->toBeInstanceOf(Component::class);
    expect($this->component->getMethod())->toBe(Request::METHOD_PATCH);
});

it('uses delete method', function () {
    expect($this->component->delete())->toBeInstanceOf(Component::class);
    expect($this->component->getMethod())->toBe(Request::METHOD_DELETE);
});


it('uses method', function () {
    expect($this->component->method(Request::METHOD_GET))->toBeInstanceOf(Component::class);
    expect($this->component->getMethod())->toBe(Request::METHOD_GET);
});

it('only allows for valid methods', function () {
    $this->component->setMethod('INVALID');
})->throws(InvalidArgumentException::class);

it('allows for case insensitive methods', function () {
    $this->component->setMethod('get');
    expect($this->component->getMethod())->toBe(Request::METHOD_GET);
});

it('can set as a download route', function () {
    expect($this->component->download())->toBeInstanceOf(Component::class);
    expect($this->component->isDownloadRoute())->toBeTrue();
    expect($this->component->isNotDownloadRoute())->toBeFalse();
});

it('prevents null values for download route', function () {
    $this->component->setDownload(null);
    expect($this->component->isDownloadRoute())->toBeFalse();
    expect($this->component->isNotDownloadRoute())->toBeTrue();
});

it('can be set as a signed route', function () {
    expect($this->component->signed())->toBeInstanceOf(Component::class);
    expect($this->component->isSignedRoute())->toBeTrue();
    expect($this->component->isNotSignedRoute())->toBeFalse();
});

it('prevents null values for signed route', function () {
    $this->component->setSigned(null);
    expect($this->component->isSignedRoute())->toBeFalse();
    expect($this->component->isNotSignedRoute())->toBeTrue();
});

it('can be set as a temporary route', function () {
    expect($this->component->temporary())->toBeInstanceOf(Component::class);
    expect($this->component->isTemporaryRoute())->toBeTrue();
    expect($this->component->isNotTemporaryRoute())->toBeFalse();
});

it('prevents null values for temporary route', function () {
    $this->component->setTemporary(null);
    expect($this->component->isTemporaryRoute())->toBeFalse();
    expect($this->component->isNotTemporaryRoute())->toBeTrue();
});

it('can set the target of the route', function () {
    expect($this->component->target('_self'))->toBeInstanceOf(Component::class);
    expect($this->component->getTarget())->toBe('_self');
});

it('prevents null values for target', function () {
    $this->component->setTarget(null);
    expect($this->component->getTarget())->toBeNull();
});

it('has a shortcut for blank', function () {
    expect($this->component->newTab())->toBeInstanceOf(Component::class);
    expect($this->component->getTarget())->toBe('_blank');
});