<?php

declare(strict_types=1);

use Honed\Core\Contracts\HigherOrder;
use Honed\Core\Contracts\ProxiesHigherOrder;
use Honed\Core\Link\Concerns\Linkable;
use Honed\Core\Link\Link;
use Honed\Core\Link\Proxies\HigherOrderLink;
use Honed\Core\Primitive;
use Illuminate\Support\Facades\URL;

class HigherOrderLinkTest extends Primitive implements ProxiesHigherOrder
{
    use Linkable;

    public static function make(): static
    {
        return new static;
    }

    public function __get($property)
    {
        return match ($property) {
            'link' => new HigherOrderLink($this),
            default => throw new \Exception("Property {$property} not found"),
        };
    }

    public function toArray(): array
    {
        return [];
    }
}

beforeEach(function () {
    $this->test = new HigherOrderLinkTest;
});

it('proxies calls to the Link object', function () {
    $product = product();
    expect($this->test->link->signedRoute('product.show', $product))
        ->toBeInstanceOf(HigherOrderLinkTest::class)
        ->getLink()->scoped(fn ($link) => $link
        ->toBeInstanceOf(Link::class)
        ->isSigned()->toBeTrue()
        ->isTemporary()->toBeFalse()
        ->getLink()->toBe(URL::signedRoute('product.show', $product))
        );
});
