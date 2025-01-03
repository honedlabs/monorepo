<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Link\Concerns\HasLink;
use Honed\Core\Tests\Stubs\Product;

use function Pest\Laravel\get;

class HasLinkTest
{
    use Evaluable;
    use HasLink;
}

beforeEach(function () {
    $this->test = new HasLinkTest;
});

it('has no link by default', function () {
    expect($this->test)
        ->getLink()->toBeNull()
        ->hasLink()->toBeFalse();
});

it('sets link', function () {
    $this->test->setLink('/');
    expect($this->test)
        ->getLink()->toBe('/')
        ->hasLink()->toBeTrue();
});

it('defaults to named routes when setting a route', function () {
    $product = product();
    $this->test->setLink('product.show', $product, false);
    expect($this->test)
        ->getLink()->toBe(route('product.show', $product, false))
        ->hasLink()->toBeTrue();
});

it('sets url', function () {
    $this->test->setUrl('/');
    expect($this->test)
        ->getLink()->toBe('/')
        ->hasLink()->toBeTrue();
});

it('sets route', function () {
    $product = product();
    $this->test->setRoute('product.show', $product);
    expect($this->test)
        ->getLink()->toBe(route('product.show', $product))
        ->hasLink()->toBeTrue();
});

// it('holds the route for future parameters', function () {
//     $product = product();
//     $this->test->setRoute('product.show');
// });

it('rejects null values', function () {
    $this->test->setLink('/');
    $this->test->setLink(null);
    expect($this->test)
        ->getLink()->toBe('/')
        ->hasLink()->toBeTrue();
});

it('chains link', function () {
    expect($this->test->link('/'))->toBeInstanceOf(HasLinkTest::class)
        ->getLink()->toBe('/')
        ->hasLink()->toBeTrue();
});

it('chains route', function () {
    $product = product();
    expect($this->test->route('product.show', $product))->toBeInstanceOf(HasLinkTest::class)
        ->getLink()->toBe(route('product.show', $product))
        ->hasLink()->toBeTrue();
});

it('chains url', function () {
    expect($this->test->url('/'))->toBeInstanceOf(HasLinkTest::class)
        ->getLink()->toBe('/')
        ->hasLink()->toBeTrue();
});

it('retrieves parameters for closure evaluation', function () {
    $this->test->setLink(fn ($product) => route('product.show', $product));
    $product = product();

    get(route('product.show', $product));

    expect($this->test)
        ->getLink()->toBe(route('product.show', $product))
        ->hasLink()->toBeTrue();
});

it('resolves link', function () {
    $this->test->setLink(fn ($product) => route('product.show', $product));
    $product = product();

    expect($this->test)
        ->resolveLink(['product' => $product])->toBe(route('product.show', $product))
        ->getLink()->toBe(route('product.show', $product))
        ->hasLink()->toBeTrue();
});

it('resolves link with typed parameters', function () {
    $this->test->setLink(fn (Product $product) => route('product.show', $product));
    $product = product();

    expect($this->test)
        ->getLink([], [Product::class => $product])->toBe(route('product.show', $product))
        ->hasLink()->toBeTrue();
});

