<?php

declare(strict_types=1);

use Honed\Form\Attributes\Hint;
use Honed\Form\Attributes\Label;
use Honed\Form\Attributes\Placeholder;
use Honed\Form\Concerns\Adaptable;
use Honed\Form\Support\Trans;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

beforeEach(function () {
    $this->class = new class()
    {
        use Adaptable;
    };
});

it('gets name from property', function (Data $data, ?string $expected) {
    expect($this->class)
        ->getName(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        public string $name;
    }, 'name'],
    fn () => [new class() extends Data
    {
        #[MapOutputName('username')]
        public string $name;
    }, 'username'],
]);

it('gets label from property', function (Data $data, ?string $expected) {
    expect($this->class)
        ->getLabel(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        #[Label('Username')]
        public string $name;
    }, 'Username'],
    fn () => [new class() extends Data
    {
        public string $name;
    }, null],
    fn () => [new class() extends Data
    {
        #[Label(new Trans('Username'))]
        public string $name;
    }, __('Username')],
]);

it('gets minimum value from property', function (Data $data, ?int $expected) {
    expect($this->class)
        ->getPropertyMin(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        #[Min(2)]
        public string $name;
    }, 2],
    fn () => [new class() extends Data
    {
        public string $name;
    }, null],
    fn () => [new class() extends Data
    {
        #[Min(0)]
        public string $name;
    }, 0],
]);

it('gets maximum value from property', function (Data $data, ?int $expected) {
    expect($this->class)
        ->getPropertyMax(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        #[Max(2)]
        public string $name;
    }, 2],
    fn () => [new class() extends Data
    {
        public string $name;
    }, null],
    fn () => [new class() extends Data
    {
        #[Max(0)]
        public string $name;
    }, 0],
]);

it('gets hint from property', function (Data $data, ?string $expected) {
    expect($this->class)
        ->getHint(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        #[Hint('Enter your username')]
        public string $name;
    }, 'Enter your username'],
    fn () => [new class() extends Data
    {
        public string $name;
    }, null],
    fn () => [new class() extends Data
    {
        #[Hint(new Trans('Enter your username'))]
        public string $name;
    }, __('Enter your username')],
]);

it('gets placeholder from property', function (Data $data, ?string $expected) {
    expect($this->class)
        ->getPlaceholder(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        #[Placeholder('Enter your username')]
        public string $name;
    }, 'Enter your username'],
    fn () => [new class() extends Data
    {
        public string $name;
    }, null],
    fn () => [new class() extends Data
    {
        #[Placeholder(new Trans('Enter your username'))]
        public string $name;
    }, __('Enter your username')],
]);

it('checks if property is required', function (Data $data, bool $expected) {
    expect($this->class)
        ->isRequired(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        #[Required]
        public ?string $name;
    }, true],
    fn () => [new class() extends Data
    {
        public ?string $name;
    }, false],
    fn () => [new class() extends Data
    {
        public string $name;
    }, true],
]);

it('checks if property is optional', function (Data $data, bool $expected) {
    expect($this->class)
        ->isOptionalProperty(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        public string|Optional $name;
    }, true],
    fn () => [new class() extends Data
    {
        public string $name;
    }, false],
]);
