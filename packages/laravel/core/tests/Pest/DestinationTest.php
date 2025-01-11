<?php

declare(strict_types=1);

use Pest\Expectation;
use Honed\Core\Destination;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request;

beforeEach(function () {
    $this->destination = Destination::make()->to('product.show');
    $this->product = product();
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

it('has method', function () {
    expect($this->destination->via(Request::METHOD_GET))
        ->getVia()->toBe(Request::METHOD_GET);
});

it('sets method to GET', function () {
    expect($this->destination->viaGet())
        ->getVia()->toBe(Request::METHOD_GET);
});

it('sets method to POST', function () {
    expect($this->destination->viaPost())
        ->getVia()->toBe(Request::METHOD_POST);
});

it('sets method to PATCH', function () {
    expect($this->destination->viaPatch())
        ->getVia()->toBe(Request::METHOD_PATCH);
});

it('sets method to PUT', function () {
    expect($this->destination->viaPut())
        ->getVia()->toBe(Request::METHOD_PUT);
});

it('sets method to DELETE', function () {
    expect($this->destination->viaDelete())
        ->getVia()->toBe(Request::METHOD_DELETE);
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
