<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\Even;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class() extends Data
    {
        #[Even]
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
    [2, true],
    [2.65, true],
    [0, true],
    [-2, true],
    [-2.65, true],
    [1, false],
    [1.65, false],
    [-1, false],
    [-1.65, false],
    [0.65, true],
    [-0.65, true],
    ['a', true],
]);
