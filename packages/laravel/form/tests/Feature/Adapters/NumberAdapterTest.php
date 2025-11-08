<?php

declare(strict_types=1);

use Honed\Form\Adapters\NumberAdapter;
use Honed\Form\Components\NumberInput;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataProperty;

beforeEach(function () {
    $this->adapter = app(NumberAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(NumberInput::class);
});

it('checks conversion', function (bool $expected, DataProperty $property) {
    expect($this->adapter)
        ->shouldConvert($property)->toBe($expected);
})->with([
    fn () => [false, property(new class() extends Data
    {
        public string $name;
    }
    )],
    fn () => [true, property(new class() extends Data
    {
        public int $stock;
    }
    )],
    fn () => [true, property(new class() extends Data
    {
        public float $price;
    }
    )],
]);
