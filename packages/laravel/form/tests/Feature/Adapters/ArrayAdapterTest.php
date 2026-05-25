<?php

declare(strict_types=1);

use App\Data\LocaleStringData;
use App\Data\StatusEnumData;
use App\Data\TagsStatusListData;
use App\Data\TagsStringListData;
use Honed\Form\Adapters\ArrayAdapter;
use Honed\Form\Components\Select;
use Spatie\LaravelData\Support\DataConfig;

beforeEach(function () {
    $this->adapter = app(ArrayAdapter::class);
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
    fn () => [true, TagsStatusListData::class],
    fn () => [true, TagsStringListData::class],
    fn () => [false, LocaleStringData::class],
    fn () => [false, StatusEnumData::class],
]);

it('checks rules conversion', function (bool $expected, array $rules) {
    expect($this->adapter)
        ->shouldConvertRules('value', $rules)->toBe($expected);
})->with([
    fn () => [false, ['required', 'numeric']],
    fn () => [true, ['required', 'array']],
    fn () => [true, ['required', 'list']],
]);

it('sets property to multiple', function (string $dataClass) {
    $property = property($dataClass);

    $dataClassConfig = app(DataConfig::class)->getDataClass($dataClass);

    expect($this->adapter->convertProperty($property, $dataClassConfig))
        ->toBeInstanceOf(Select::class)
        ->isMultiple()->toBeTrue();
})->with([
    fn () => TagsStatusListData::class,
]);
