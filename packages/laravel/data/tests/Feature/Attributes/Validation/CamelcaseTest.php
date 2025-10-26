<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\Camelcase;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class extends Data
    {
        #[Camelcase]
        public mixed $value;
    };
});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'value' => $input,
    ], $this->data::getValidationRules([
        'value' => $input,
    ])))->passes()->toBe($expected);
})->with([
    ['foo', true],
    ['Foo', true],
    ['fooBar', true],
    ['fooBarBaz', true],
    ['fooBarBâz', true],
    ['fOo', true],
    ['PostScript', true],
    ['iPhone', true],
    ['foobaR', false],
    ['FoobaR', false],
    ['FOo', false],
    ['FOO', false],
    ['fo0bar', false],
    ['-fooBar', false],
    ['-fooBar-', false],
]);
