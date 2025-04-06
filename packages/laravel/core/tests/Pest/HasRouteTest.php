<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasRoute;
use Honed\Core\Tests\Stubs\Product;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request;

beforeEach(function () {
    $this->test = new class {
        use Evaluable, HasRoute;
    };
});

it('accesses route', function () {
    $product = product();

    expect($this->test)
        ->hasRoute()->toBeFalse()
        ->getRoute()->toBeNull()
        ->route('products.show', $product)->toBe($this->test)
        ->hasRoute()->toBeTrue()
        ->getRoute()->toBe(route('products.show', $product));
});

it('evaluates route', function () {
    $product = product();

    expect($this->test)
        ->route(fn (Product $product) => route('products.show', $product))->toBe($this->test)
        ->getRoute(['product' => $product])->toBe(route('products.show', $product));
});

it('accesses url', function () {
    expect($this->test)
        ->hasRoute()->toBeFalse()
        ->getRoute()->toBeNull()
        ->url('https://example.com')->toBe($this->test)
        ->hasRoute()->toBeTrue()
        ->getRoute()->toBe('https://example.com');
});

it('accesses method', function () {
    expect($this->test)
        ->getMethod()->toBe(Request::METHOD_GET)
        ->method(Request::METHOD_POST)->toBe($this->test)
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

    $product = product();

    expect($this->test)
        ->route('products.show', $product)->toBe($this->test)
        ->routeToArray()->toBe([
            'url' => route('products.show', $product),
            'method' => Request::METHOD_GET,
        ]);
});