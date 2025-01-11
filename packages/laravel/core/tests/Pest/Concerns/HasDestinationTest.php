<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasDestination;
use Honed\Core\Destination;

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
        ->getDestination()->toBe($destination)
        ->resolveDestination()->toBe(route('product.show', $this->product));
});

it('sets closure', function () {
    $fn = fn (Destination $destination) => $destination->to('https://google.com');
    expect($this->test->to($fn))
        ->toBeInstanceOf(DestinationTest::class)
        ->hasDestination()->toBeTrue()
        // ->getDestination()->scoped(fn ($destination) => $destination
        //     ->
        // )
        ->resolveDestination()->toBe('https://google.com');
});
