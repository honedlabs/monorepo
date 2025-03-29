<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasRoute;
use Honed\Core\Tests\Stubs\Product;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request;

class RouteTest
{
    use Evaluable;
    use HasRoute;
}

beforeEach(function () {
    $this->test = new RouteTest;
    $this->route = 'products.show';
    $this->param = product();
    $this->url = '/';
});

it('sets route', function () {
    expect($this->test->route($this->route, $this->param))
        ->toBeInstanceOf(RouteTest::class)
        ->hasRoute()->toBeTrue();
});

it('gets route', function () {
    expect($this->test->route($this->route, $this->param))
        ->getRoute()->toBe(route($this->route, $this->param))
        ->hasRoute()->toBeTrue();

    expect($this->test->route(fn () => route($this->route, $this->param)))
        ->getRoute()->toBe(route($this->route, $this->param))
        ->hasRoute()->toBeTrue();
});

it('resolves route', function () {
    expect($this->test->route(fn (Product $product) => route($this->route, $product)))
        ->resolveRoute(['product' => $this->param])->toBe(route($this->route, $this->param));
});

it('sets url', function () {
    expect($this->test->url($this->url))
        ->toBeInstanceOf(RouteTest::class)
        ->hasRoute()->toBeTrue();
});

it('gets url', function () {
    expect($this->test->url($this->url))
        ->getRoute()->toBe(URL::to($this->url))
        ->hasRoute()->toBeTrue();

    expect($this->test->url(fn () => $this->url))
        ->getRoute()->toBe($this->url)
        ->hasRoute()->toBeTrue();
});

it('sets method', function () {
    expect($this->test->method(Request::METHOD_POST))
        ->toBeInstanceOf(RouteTest::class);
});

it('gets method', function () {
    expect($this->test->method(Request::METHOD_POST))
        ->getMethod()->toBe(Request::METHOD_POST);
});

it('validates method', function ($input) {
    $this->test->method($input);
})->throws(\InvalidArgumentException::class)->with([
    [null],
    ['INVALID'],
]);

it('has array representation', function () {
    expect($this->test)
        ->routeToArray()->toBeNull();

    expect($this->test->route($this->route, $this->param))
        ->routeToArray()->toBe([
            'url' => route($this->route, $this->param),
            'method' => Request::METHOD_GET,
        ]);
});