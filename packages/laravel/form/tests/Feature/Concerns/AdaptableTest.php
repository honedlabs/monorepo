<?php

declare(strict_types=1);

use App\Enums\Status;
use Honed\Form\Attributes\Attributes;
use Honed\Form\Attributes\ClassName;
use Honed\Form\Attributes\Hint;
use Honed\Form\Attributes\Label;
use Honed\Form\Attributes\Multiple;
use Honed\Form\Attributes\Placeholder;
use Honed\Form\Concerns\Adaptable;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\In;
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
        ->getNameFromProperty(property($data))->toBe($expected);
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
        ->getLabelFromProperty(property($data))->toBe($expected);
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
        #[Label('Username')]
        public string $name;
    }, __('Username')],
]);

it('gets minimum value from property', function (Data $data, ?int $expected) {
    expect($this->class)
        ->getMinFromProperty(property($data))->toBe($expected);
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
        ->getMaxFromProperty(property($data))->toBe($expected);
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
        ->getHintFromProperty(property($data))->toBe($expected);
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
        #[Hint('Enter your username')]
        public string $name;
    }, __('Enter your username')],
]);

it('gets placeholder from property', function (Data $data, ?string $expected) {
    expect($this->class)
        ->getPlaceholderFromProperty(property($data))->toBe($expected);
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
        #[Placeholder('Enter your username')]
        public string $name;
    }, __('Enter your username')],
]);

it('gets default value from property', function (Data $data, mixed $expected) {
    expect($this->class)
        ->getDefaultValueFromProperty(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        public string $name;
    }, null],
    fn () => [new class() extends Data
    {
        public string $name = 'John Doe';
    }, 'John Doe'],
]);

it('gets attributes from property', function (Data $data, array $expected) {
    expect($this->class)
        ->getAttributesFromProperty(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        public string $name;
    }, []],
    fn () => [new class() extends Data
    {
        #[Attributes(['class' => 'form-control'])]
        public string $name;
    }, ['class' => 'form-control']],
]);

it('gets class name from property', function (Data $data, ?string $expected) {
    expect($this->class)
        ->getClassNameFromProperty(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        public string $name;
    }, null],
    fn () => [new class() extends Data
    {
        #[ClassName('bg-red-500 text-white')]
        public string $name;
    }, 'bg-red-500 text-white'],
]);

it('gets options from property', function (Data $data, array|string $expected) {
    expect($this->class)
        ->getOptionsFromProperty(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        public array $name;
    }, []],
    fn () => [new class() extends Data
    {
        #[In('a', 'b')]
        public array $name;
    }, ['a', 'b']],
    fn () => [new class() extends Data
    {
        /** @var list<Status> */
        public array $name;
    }, []], // Pint refactors this to remove the namespacing, else it will pass
]);

it('checks if property is required', function (Data $data, bool $expected) {
    expect($this->class)
        ->isRequiredProperty(property($data))->toBe($expected);
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

it('checks if property is multiple', function (Data $data, ?bool $expected) {
    expect($this->class)
        ->isMultipleProperty(property($data))->toBe($expected);
})->with([
    fn () => [new class() extends Data
    {
        #[Multiple]
        public array $name;
    }, true],
    fn () => [new class() extends Data
    {
        public array $name;
    }, null],
]);
