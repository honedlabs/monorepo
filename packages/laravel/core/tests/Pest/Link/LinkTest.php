<?php

declare(strict_types=1);

use Honed\Core\Link\Link;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\URL;

it('can be made', function () {
    expect(Link::make())->toBeInstanceOf(Link::class);
});

it('has array representation', function () {
    expect(Link::make('/')->toArray())->toEqual([
        'url' => '/',
        'method' => Request::METHOD_GET,
    ]);
});

it('has shorthand `to` method', function () {
    expect(Link::make()->to('/'))->toBeInstanceOf(Link::class)
        ->getLink()->toBe('/')
        ->hasLink()->toBeTrue();
});

it('has shorthand `signedRoute` method', function () {
    $product = product();

    expect(Link::make()->signedRoute('product.show', $product))->toBeInstanceOf(Link::class)
        ->getLink()->toBe(URL::signedRoute('product.show', $product))
        ->isSigned()->toBeTrue()
        ->isTemporary()->toBeFalse();
});

it('can be null', function () {
    expect(Link::make())->toBeInstanceOf(Link::class)
        ->hasLink()->toBeFalse()
        ->getLink()->toBeNull();
});
