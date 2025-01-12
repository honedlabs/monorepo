<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasDestination;
use Honed\Core\Destination;
use Honed\Core\Tests\Stubs\Product;

class DestinationTest
{
    use HasDestination;
}

beforeEach(function () {
    $this->test = new DestinationTest;
    $this->product = product();
});

it('sets class', function () {
    $destination = Destination::make('product.show', $this->product);
    expect($this->test->to($destination))
        ->toBeInstanceOf(DestinationTest::class)
        ->hasDestination()->toBeTrue()
        ->getDestination()->scoped(fn ($destination) => $destination
            ->goesTo()->toBe('product.show')
            ->getParameters()->toBe($this->product)
            ->getHref($this->product)->toBe(route('product.show', $this->product))
        );
});

it('sets closure', function () {
    $fn = fn (Product $product) => route('product.show', $product);

    expect($this->test->to($fn))
        ->toBeInstanceOf(DestinationTest::class)
        ->hasDestination()->toBeTrue()
        ->getDestination()->scoped(fn ($destination) => $destination
            ->goesTo()->toBeInstanceOf(\Closure::class)
            ->getHref($this->product)->toBe(route('product.show', $this->product))
        );
});

it('sets string', function () {
    expect($this->test->to('https://honed.dev'))
        ->toBeInstanceOf(DestinationTest::class)
        ->hasDestination()->toBeTrue()
        ->getDestination()->scoped(fn ($destination) => $destination
            ->goesTo()->toBe('https://honed.dev')
            ->getHref()->toBe('https://honed.dev')
        );
});

it('sets destination closure', function () {
    expect($this->test->to(fn (Destination $d) => $d
        ->to('product.show')
        ->parameters($this->product)
    ))->toBeInstanceOf(DestinationTest::class)
        ->hasDestination()->toBeTrue()
        ->getDestination()->scoped(fn ($destination) => $destination
            ->goesTo()->toBe('product.show')
            ->getParameters()->toBe($this->product)
            ->getHref($this->product)->toBe(route('product.show', $this->product))
        );
});

it('has alias destination', function () {
    expect($this->test->destination('product.show', $this->product))
        ->toBeInstanceOf(DestinationTest::class)
        ->hasDestination()->toBeTrue();
});
