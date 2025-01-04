<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Link\Link;
use Honed\Core\Link\Concerns\Linkable;

class LinkableTest
{
    use Linkable;
    use Evaluable;
}

beforeEach(function () {
    $this->test = new LinkableTest;
});

it('has no link by default', function () {
    expect($this->test)
        ->getLink()->toBeNull()
        ->isLinkable()->toBeFalse();
});

it('sets link', function () {
    $this->test->setLink(Link::make('/'));
    expect($this->test)
        ->getLink()->toBeInstanceOf(Link::class)
        ->isLinkable()->toBeTrue();
});

it('rejects null values', function () {
    $this->test->setLink(Link::make('/'));
    $this->test->setLink(null);
    expect($this->test)
        ->getLink()->toBeInstanceOf(Link::class)
        ->isLinkable()->toBeTrue();
});

it('chains link with class', function () {
    expect($this->test->link(Link::make('/')))->toBeInstanceOf(LinkableTest::class)
        ->getLink()->toBeInstanceOf(Link::class);
});

it('chains link with null rejections', function () {
    expect($this->test->link())->toBeInstanceOf(LinkableTest::class)
        ->getLink()->toBeNull()
        ->isLinkable()->toBeFalse();
});

it('chains link with array assignments', function () {
    $product = product();

    expect($this->test->link([
        'signed' => false,
        'linkDuration' => 10,
        'link' => route('product.show', $product),
    ]))->toBeInstanceOf(LinkableTest::class)
        ->isLinkable()->toBeTrue()
        ->getLink()->scoped(fn ($link) => $link
            ->toBeInstanceOf(Link::class)
            ->isSigned()->toBeFalse()
            ->getLinkDuration()->toBe(10)
            ->getLink()->toBe(route('product.show', $product))
        );
});

it('chains link with closure', function () {
    $product = product();

    expect($this->test->link(fn (Link $link) => $link
        ->link(route('product.show', $product))
        ->signed(false)
        ->linkDuration(10)
    ))->toBeInstanceOf(LinkableTest::class)
        ->isLinkable()->toBeTrue()
        ->getLink()->scoped(fn ($link) => $link
            ->toBeInstanceOf(Link::class)
            ->isSigned()->toBeFalse()
            ->getLinkDuration()->toBe(10)
            ->getLink()->toBe(route('product.show', $product))
        );
});

it('chains link with parameters', function () {
    $product = product();

    expect($this->test->link('product.show', $product))->toBeInstanceOf(LinkableTest::class)
        ->isLinkable()->toBeTrue()
        ->getLink()->scoped(fn ($link) => $link
            ->toBeInstanceOf(Link::class)
            ->getLink()->toBe(route('product.show', $product))
        );
});

it('has shorthand `route` method', function () {
    $product = product();

    expect($this->test->route('product.show', $product))->toBeInstanceOf(LinkableTest::class)
        ->isLinkable()->toBeTrue()
        ->getLink()->scoped(fn ($link) => $link
            ->toBeInstanceOf(Link::class)
            ->getLink()->toBe(route('product.show', $product))
        );
});

it('has shorthand `url` method', function () {
    expect($this->test->url('/'))->toBeInstanceOf(LinkableTest::class)
        ->isLinkable()->toBeTrue()
        ->getLink()->scoped(fn ($link) => $link
            ->toBeInstanceOf(Link::class)
            ->getLink()->toBe('/')
        );
});
