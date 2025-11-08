<?php

declare(strict_types=1);

use Honed\Form\Adapters\TextAdapter;
use Honed\Form\Attributes\Autofocus;
use Honed\Form\Attributes\Hint;
use Honed\Form\Attributes\Label;
use Honed\Form\Attributes\Placeholder;
use Honed\Form\Components\Input;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataConfig;

beforeEach(function () {
    $this->adapter = app(TextAdapter::class);

    $this->class = new class() extends Data
    {
        #[Autofocus]
        #[Label('Username')]
        #[MapOutputName('username')]
        #[Hint('Enter your username')]
        #[Placeholder('e.g. john_doe')]
        #[Required, Min(2), Max(255)]
        public ?string $name;
    };
});

it('converts to component', function (bool $expected, Data $data) {
    $property = property($data);

    $dataClass = app(DataConfig::class)->getDataClass($data::class);

    if ($expected) {
        expect($this->adapter)
            ->getComponent($property, $dataClass)->toBeInstanceOf(Input::class);
    } else {
        expect($this->adapter)
            ->getComponent($property, $dataClass)->toBeNull();
    }
})->with([
    fn () => [true, $this->class],
    fn () => [false, new class() extends Data
    {
        public bool $best_seller;
    },
    ],
]);

it('gets label', function () {
    expect($this->adapter)
        ->getLabel(property($this->class))->toBe('Username');
});

it('gets hint', function () {
    expect($this->adapter)
        ->getHint(property($this->class))->toBe('Enter your username');
});

it('gets placeholder', function () {
    expect($this->adapter)
        ->getPlaceholder(property($this->class))->toBe('e.g. john_doe');
});

it('gets min value', function () {
    expect($this->adapter)
        ->getMin(property($this->class))->toBe(2);
});

it('gets max value', function () {
    expect($this->adapter)
        ->getMax(property($this->class))->toBe(255);
});

it('gets name', function () {
    expect($this->adapter)
        ->getName(property($this->class))->toBe('username');
});

// it('checks if required', function () {
//     expect($this->adapter)
//         ->isRequired(property($this->class))->toBe(true);
// });

// it('checks if autofocused', function () {
//     expect($this->adapter)
//         ->isAutofocused(property($this->class))->toBe(true);
// });

// it('checks if optional', function () {
//     expect($this->adapter)
//         ->isOptional(property($this->class))->toBe(false);
// });
