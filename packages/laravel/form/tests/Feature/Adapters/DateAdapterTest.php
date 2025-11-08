<?php

declare(strict_types=1);

use Honed\Form\Adapters\DateAdapter;
use Honed\Form\Components\DateField;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataProperty;

beforeEach(function () {
    $this->adapter = app(DateAdapter::class);
});

it('has field', function () {
    expect($this->adapter)
        ->field()->toBe(DateField::class);
});

it('checks conversion', function (bool $expected, DataProperty $property) {
    expect($this->adapter)
        ->shouldConvert($property)->toBe($expected);
})->with([
    fn () => [false, property(new class() extends Data
    {
        public ?string $name;
    }
    )],
    fn () => [true, property(new class() extends Data
    {
        #[Date]
        public ?string $created_at;
    }
    )],
]);
