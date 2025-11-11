<?php

declare(strict_types=1);

use Honed\Form\Adapters\DateAdapter;
use Honed\Form\Components\DatePicker;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataConfig;

beforeEach(function () {
    $this->adapter = app(DateAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(DatePicker::class);
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
    },
    ],
    fn () => [true, new class() extends Data
    {
        #[Date]
        public ?string $created_at;
    },
    ],
]);

it('checks rules conversion', function (bool $expected, array $rules) {
    expect($this->adapter)
        ->shouldConvertRules('value', $rules)->toBe($expected);
})->with([
    fn () => [true, ['required', 'date']],
    fn () => [false, ['required', 'string']],
]);
