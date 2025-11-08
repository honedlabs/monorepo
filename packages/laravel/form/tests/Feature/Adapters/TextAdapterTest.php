<?php

declare(strict_types=1);

use Honed\Form\Adapters\TextAdapter;
use Honed\Form\Components\Input;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\DataConfig;

beforeEach(function () {
    $this->adapter = app(TextAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(Input::class);
});

it('checks property conversion', function (bool $expected, Data $data) {
    $property = property($data);

    $dataClass = app(DataConfig::class)->getDataClass($data::class);

    expect($this->adapter)
        ->shouldConvertProperty($property, $dataClass)->toBe($expected);
})->with([
    fn () => [false, new class() extends Data
    {
        public int $stock;
    }
    ],
    fn () => [true, new class() extends Data
    {
        public string $name;
    }
    ],
    fn () => [true, new class() extends Data
    {
        public ?string $description;
    }
    ],
]);

it('checks rules conversion', function (bool $expected, array $rules) {
    expect($this->adapter)
        ->shouldConvertRules('value', $rules)->toBe($expected);
})->with([
    fn () => [true, ['nullable', 'string']],
    fn () => [false, ['required', 'numeric']],
]);