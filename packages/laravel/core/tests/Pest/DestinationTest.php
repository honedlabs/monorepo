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
});

it('makes', function () {
    expect($this->destination)->toBeInstanceOf(Destination::class);
});

it('has array representation', function () {
    expect(Destination::make()->toArray())
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['href', 'method']);
});

it('sets destination', function () {
    expect($this->destination->to('https://honed.dev'))
        ->toBeInstanceOf(Destination::class)
        ->hasDestination()->toBeTrue()
        ->resolve($this->product)->toBe('https://honed.dev');
});

it('gets destination', function () {
    expect($this->destination->to('https://honed.dev'))
        ->hasDestination()->toBeTrue()
        ->to()->toBe('https://honed.dev')
        ->resolve($this->product)->toBe('https://honed.dev');
});

it('sets destination with parameters', function () {
    expect($this->destination->to('product.show', $this->product))
        ->hasDestination()->toBeTrue()
        ->to()->toBe('product.show')
        ->resolve($this->product)->toBe(route('product.show', $this->product));
});

it('has method', function () {
    expect($this->destination->as(Request::METHOD_GET))
        ->as()->toBe(Request::METHOD_GET);
});

it('sets method to GET', function () {
    expect($this->destination->asGet())
        ->as()->toBe(Request::METHOD_GET);
});

it('sets method to POST', function () {
    expect($this->destination->asPost())
        ->as()->toBe(Request::METHOD_POST);
});

it('sets method to PATCH', function () {
    expect($this->destination->asPatch())
        ->as()->toBe(Request::METHOD_PATCH);
});

it('sets method to PUT', function () {
    expect($this->destination->asPut())
        ->as()->toBe(Request::METHOD_PUT);
});

it('sets method to DELETE', function () {
    expect($this->destination->asDelete())
        ->as()->toBe(Request::METHOD_DELETE);
});

it('has parameters', function () {
    expect($this->destination->parameters($this->product))
        ->toBeInstanceOf(Destination::class)
        ->parameters()->toBe($this->product);
});

it('is signed', function () {
    expect($this->destination->signed())
        ->toBeInstanceOf(Destination::class)
        ->isSigned()->toBeTrue()
        ->resolve($this->product)->toBe(URL::signedRoute('product.show', $this->product));
});

it('is new tab', function () {
    expect($this->destination->inNewTab())
        ->toBeInstanceOf(Destination::class)
        ->isNewTab()->toBeTrue()
        ->resolve($this->product)->toBe(route('product.show', $this->product));
});

it('has duration', function () {
    expect($this->destination->signed()->duration(10))
        ->toBeInstanceOf(Destination::class)
        ->duration()->toBe(10)
        ->resolve($this->product)->toBe(URL::temporarySignedRoute('product.show', 10, $this->product));
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
