<?php

declare(strict_types=1);

use Pest\Expectation;
use Honed\Core\Destination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request;

beforeEach(function () {
    $this->destination = Destination::make()->to('product.show');
    $this->product = product();
    $this->get = Str::lower(Request::METHOD_GET);
    $this->post = Str::lower(Request::METHOD_POST);
    $this->patch = Str::lower(Request::METHOD_PATCH);
    $this->put = Str::lower(Request::METHOD_PUT);
    $this->delete = Str::lower(Request::METHOD_DELETE);
});

it('makes', function () {
    expect($this->destination)
        ->toBeInstanceOf(Destination::class);
});

it('has array representation', function () {
    expect(Destination::make()->toArray())
        ->toBeArray()
        ->toHaveCount(3)
        ->toHaveKeys(['href', 'method', 'tab']);
});

it('sets destination', function () {
    expect($this->destination->to('https://honed.dev'))
        ->toBeInstanceOf(Destination::class)
        ->goesTo()->toBe('https://honed.dev')
        ->resolve($this->product)->toBe('https://honed.dev');
});

it('gets destination', function () {
    expect($this->destination->to('https://honed.dev'))
        ->goesTo()->toBe('https://honed.dev')
        ->resolve($this->product)->toBe('https://honed.dev');
});

it('sets destination with parameters', function () {
    expect($this->destination->to('product.show', $this->product))
        ->goesTo()->toBe('product.show')
        ->resolve($this->product)->toBe(route('product.show', $this->product));
});

it('sets method', function () {
    expect($this->destination->via(Request::METHOD_POST))
        ->getVia()->toBe($this->post);
});

it('has parameters', function () {
    expect($this->destination->parameters($this->product))
        ->toBeInstanceOf(Destination::class)
        ->getParameters()->toBe($this->product);
});

it('is signed', function () {
    expect($this->destination->signed())
        ->toBeInstanceOf(Destination::class)
        ->isSigned()->toBeTrue()
        ->resolve($this->product)->toBe(URL::signedRoute('product.show', $this->product));
});

it('can tab', function () {
    expect($this->destination->tab())
        ->toBeInstanceOf(Destination::class)
        ->isTab()->toBeTrue()
        ->resolve($this->product)->toBe(route('product.show', $this->product));
});

it('is temporary', function () {
    expect($this->destination->signed()->temporary())
        ->toBeInstanceOf(Destination::class)
        ->isTemporary()->toBeTrue()
        ->resolve($this->product)->scoped(function (Expectation $url) {
            expect(str($url->value))
                ->before('?')->toString()->toBe(route('product.show', $this->product));
            expect(str($url->value)->after('?')
                ->explode('&')
                ->map(fn ($pair) => str($pair)
                    ->before('=')
                    ->toString())
                ->all())
                ->toEqual(['expires', 'signature']);
        });
});
