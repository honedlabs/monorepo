<?php

declare(strict_types=1);

use App\Data\Validation\MaxWordsData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'value' => $input,
    ], MaxWordsData::getValidationRules([
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
