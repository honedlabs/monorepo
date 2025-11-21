<?php

declare(strict_types=1);

use App\Enums\Status;
use Honed\Form\Adapters\ArrayAdapter;
use Honed\Form\Components\Select;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataConfig;

beforeEach(function () {
    $this->adapter = app(ArrayAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(Select::class);
});

it('checks property conversion', function (bool $expected, Data $data) {
    $property = property($data);

    $dataClass = app(DataConfig::class)->getDataClass($data::class);

    expect($this->adapter)
        ->shouldConvertProperty($property, $dataClass)->toBe($expected);
})->with([
    fn () => [true, new class() extends Data
    {
        /** @var list<Status> */
        public array $tags;
    }],
    // fn () => [false, new class() extends Data
    // {
    //     public string $locale;
    // }],
    // fn () => [false, new class() extends Data
    // {
    //     public Status $status;
    // }],
])->only();

it('checks rules conversion', function (bool $expected, array $rules) {
    expect($this->adapter)
        ->shouldConvertRules('value', $rules)->toBe($expected);
})->with([
    fn () => [false, ['required', 'numeric']],
    fn () => [true, ['required', 'array']],
    fn () => [true, ['required', 'list']],
]);
