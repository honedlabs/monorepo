<?php

declare(strict_types=1);

use App\Data\LocaleStringData;
use App\Data\StatusEnumData;
use Honed\Form\Adapters\EnumAdapter;
use Honed\Form\Components\Select;
use Spatie\LaravelData\Support\DataConfig;

beforeEach(function () {
    $this->adapter = app(EnumAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(Select::class);
});

it('checks property conversion', function (bool $expected, string $dataClass) {
    $property = property($dataClass);

    $dataClassConfig = app(DataConfig::class)->getDataClass($dataClass);

    expect($this->adapter)
        ->shouldConvertProperty($property, $dataClassConfig)->toBe($expected);
})->with([
    fn () => [false, LocaleStringData::class],
    fn () => [true, StatusEnumData::class],
]);

it('checks rules conversion', function (bool $expected, array $rules) {
    expect($this->adapter)
        ->shouldConvertRules('value', $rules)->toBe($expected);
})->with([
    fn () => [false, ['required', 'numeric']],
]);
