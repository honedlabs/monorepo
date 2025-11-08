<?php

declare(strict_types=1);

use Honed\Form\Adapters\DefaultAdapter;
use Honed\Form\Components\Input;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataProperty;

beforeEach(function () {
    $this->adapter = app(DefaultAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(Input::class);
});

it('checks conversion', function (bool $expected, DataProperty $property) {
    expect($this->adapter)
        ->shouldConvert($property)->toBe($expected);
})->with([
    fn () => [true, property(new class() extends Data
    {
        public ?string $name;
    }
    )],
    fn () => [true, property(new class() extends Data
    {
        public int $stock;
    }
    )],
]);
