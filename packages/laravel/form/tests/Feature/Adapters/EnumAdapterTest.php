<?php

declare(strict_types=1);

use App\Enums\Locale;
use App\Enums\Status;
use Spatie\LaravelData\Data;
use Honed\Form\Components\Select;
use Honed\Form\Adapters\EnumAdapter;
use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Support\DataProperty;

beforeEach(function () {
    $this->adapter = app(EnumAdapter::class);
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
    fn () => [false, new class() extends Data
    {
        public string $locale;
    }
    ],
    fn () => [true, new class() extends Data
    {
        public Status $status;
    }
    ],
]);
