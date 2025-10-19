<?php

declare(strict_types=1);

use App\Data\Validation\SignedTinyIntegerData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], SignedTinyIntegerData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, -128],
    [true, 127],
    [true, 0],
    [false, 128],
    [false, -129],
    [false, 'foo'],
    [false, ''],
]);
