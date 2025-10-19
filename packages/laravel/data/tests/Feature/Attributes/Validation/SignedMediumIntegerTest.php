<?php

declare(strict_types=1);

use App\Data\Validation\SignedMediumIntegerData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], SignedMediumIntegerData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, -8388608],
    [true, 8388607],
    [true, 0],
    [false, 8388608],
    [false, -8388609],
    [false, 'foo'],
    [false, ''],
]);
