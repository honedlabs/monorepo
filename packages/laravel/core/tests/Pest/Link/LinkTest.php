<?php

declare(strict_types=1);

use Honed\Core\Link\Link;
use Symfony\Component\HttpFoundation\Request;

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
    expect(Link::make()->signedRoute('home'))->toBeInstanceOf(Link::class)
        ->getLink()->toBe('home')
        ->isSigned()->toBeTrue()
        ->isTemporary()->toBeFalse();
});

