<?php

declare(strict_types=1);

use App\Data\Validation\UnsignedMediumIntegerData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], UnsignedMediumIntegerData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 0],
    [true, 16777215],
    [false, 16777216],
    [false, -1],
    [false, 'foo'],
    [false, ''],
]);
