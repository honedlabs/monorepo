<?php

declare(strict_types=1);

use Honed\Form\Adapters\BooleanAdapter;
use Honed\Form\Components\Checkbox;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Support\DataProperty;

beforeEach(function () {
    $this->adapter = app(BooleanAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(Checkbox::class);
});

it('checks property conversion', function (bool $expected, Data $data) {
    $property = property($data);

    $dataClass = app(DataConfig::class)->getDataClass($data::class);

    expect($this->adapter)
        ->shouldConvertProperty($property, $dataClass)->toBe($expected);
})->with([
    fn () => [false, new class() extends Data
    {
        public ?string $name;
    }
    ],
    fn () => [true, new class() extends Data
    {
        public bool $best_seller;
    }
    ],
]);

it('checks rules conversion', function (bool $expected, array $rules) {
    expect($this->adapter)
        ->shouldConvertRules('value', $rules)->toBe($expected);
})->with([
    fn () => [true, ['required', 'boolean']],
    fn () => [false, ['required', 'string']],
]);