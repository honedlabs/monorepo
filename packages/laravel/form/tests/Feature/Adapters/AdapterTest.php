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

it('converts property to component', function (bool $expected, Data $data) {
    $property = property($data);

    $dataClass = app(DataConfig::class)->getDataClass($data::class);

    if ($expected) {
        expect($this->adapter)
            ->getPropertyComponent($property, $dataClass)->toBeInstanceOf(Input::class);
    } else {
        expect($this->adapter)
            ->getPropertyComponent($property, $dataClass)->toBeNull();
    }
})->with([
    fn () => [true, $this->class],
    fn () => [false, new class() extends Data
    {
        public bool $best_seller;
    },
    ],
]);
