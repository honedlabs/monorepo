<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\MaxWords;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class extends Data
    {
        #[MaxWords(2)]
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
    ['one', true],
    ['one two', true],
    ['one two three', false],
    [5, true],
    ['', true],
    ['one-two-three', true],
]);
