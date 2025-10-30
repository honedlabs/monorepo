<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\Odd;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class() extends Data
    {
        #[Odd]
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
    [2, false],
    [2.65, false],
    [0, false],
    [-2, false],
    [-2.65, false],
    [1, true],
    [1.65, true],
    [-1, true],
    [-1.65, true],
    [0.65, false],
    [-0.65, false],
    ['a', false],
]);
