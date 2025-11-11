<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\HexColor;
use Honed\Form\Adapters\ColorAdapter;
use Honed\Form\Components\ColorPicker;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataConfig;

beforeEach(function () {
    $this->adapter = app(ColorAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(ColorPicker::class);
});

it('checks property conversion', function (bool $expected, Data $data) {
    $property = property($data);

    $dataClass = app(DataConfig::class)->getDataClass($data::class);

    expect($this->adapter)
        ->shouldConvertProperty($property, $dataClass)->toBe($expected);
})->with([
    fn () => [true, new class() extends Data
    {
        #[HexColor]
        public ?string $color;
    }],
    fn () => [false, new class() extends Data
    {
        public ?string $color;
    }],
]);

it('checks rules conversion', function (bool $expected, array $rules) {
    expect($this->adapter)
        ->shouldConvertRules('value', $rules)->toBe($expected);
})->with([
    fn () => [true, ['required', 'hex_color']],
    fn () => [false, ['required', 'string']],
]);
