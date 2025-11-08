<?php

declare(strict_types=1);

use App\Data\ProductData;
use Spatie\LaravelData\Data;
use Honed\Form\Adapters\NumericAdapter;
use Honed\Form\Components\DateField;
use Honed\Form\Components\NumberInput;
use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Attributes\Validation\Date;

beforeEach(function () {
    $this->adapter = app(NumericAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(NumberInput::class);
});

it('checks conversion', function (bool $expected, DataProperty $property) {
    expect($this->adapter)
        ->shouldConvert($property)->toBe($expected);
})->with([
    fn () => [false, property(new class extends Data
        {
            public string $name;
        }
    )],
    fn () => [true, property(new class extends Data
        {
            public int $stock;
        }
    )],
    fn () => [true, property(new class extends Data
        {
            public float $price;
        }
    )],
]);