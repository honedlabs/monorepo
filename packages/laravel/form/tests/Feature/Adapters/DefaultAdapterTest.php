<?php

declare(strict_types=1);

use Spatie\LaravelData\Data;
use Honed\Form\Components\Input;
use Honed\Form\Adapters\DefaultAdapter;
use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Support\DataProperty;

beforeEach(function () {
    $this->adapter = app(DefaultAdapter::class);
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
    fn () => [true, new class() extends Data
    {
        public ?string $name;
    }
    ],
    fn () => [true, new class() extends Data
    {
        public int $stock;
    }
    ],
]);

it('checks rules conversion', function (array $rules) {
    expect($this->adapter)
        ->shouldConvertRules('value', $rules)->toBeTrue();
})->with([
    fn () => [['nullable', 'date']],
    fn () => [['required', 'string']],
]);

