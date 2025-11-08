<?php

declare(strict_types=1);

use App\Enums\Locale;
use App\Enums\Status;
use Honed\Form\Adapters\EnumAdapter;
use Honed\Form\Components\Select;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataProperty;

beforeEach(function () {
    $this->adapter = app(EnumAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(Select::class);
});

it('checks conversion', function (bool $expected, DataProperty $property) {
    expect($this->adapter)
        ->shouldConvert($property)->toBe($expected);
})->with([
    fn () => [false, property(new class() extends Data
    {
        public string $locale;
    }
    )],
    fn () => [true, property(new class() extends Data
    {
        public Locale $locale;
    }
    )],
    fn () => [true, property(new class() extends Data
    {
        public Status $status;
    }
    )],
]);
