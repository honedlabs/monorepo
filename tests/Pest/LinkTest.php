<?php

use Honed\Crumb\Crumb;

beforeEach(function () {
    $this->crumb = Crumb::make('Home');
});

it('can set the link through chaining', function () {
    expect($this->crumb->link('/'))->toBeInstanceOf(Crumb::class)
        ->hasLink()->toBeTrue()
        ->getLink()->toBe('/');
});

it('can set the link quietly', function () {
    $this->crumb->setLink('/');

    expect($this->crumb)
        ->hasLink()->toBeTrue()
        ->getLink()->toBe('/');
});

it('can set the link quietly as a route', function () {
    $product = product();

    $this->crumb->setLink('product.show', $product);

    expect($this->crumb)
        ->hasLink()->toBeTrue()
        ->getLink()->toBe(route('product.show', $product));
});

it('does not accept null values for the link', function () {
    $this->crumb->setLink(null);

    expect($this->crumb)->hasLink()->toBeFalse();
});

it('can set a named route quietly', function () {
    $product = product();

    $this->crumb->setRoute('product.show', $product);

    expect($this->crumb)
        ->hasLink()->toBeTrue()
        ->getLink()->toBe(route('product.show', $product));
});

it('can set a named route through chaining', function () {
    $product = product();

    expect($this->crumb->route('product.show', $product))->toBeInstanceOf(Crumb::class)
        ->hasLink()->toBeTrue()
        ->getLink()->toBe(route('product.show', $product));
});

it('can set a url quietly', function () {
    $this->crumb->setUrl('https://example.com');

    expect($this->crumb)
        ->hasLink()->toBeTrue()
        ->getLink()->toBe('https://example.com');
});

it('can set a url through chaining', function () {
    expect($this->crumb->url('https://example.com'))->toBeInstanceOf(Crumb::class)
        ->hasLink()->toBeTrue()
        ->getLink()->toBe('https://example.com');
});

it('can set the link as a closure', function () {
    $this->crumb->setLink(fn () => 'https://example.com');

    expect($this->crumb)
        ->hasLink()->toBeTrue()
        ->getLink()->toBe('https://example.com');
});
