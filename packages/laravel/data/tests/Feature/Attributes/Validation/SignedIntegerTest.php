<?php

declare(strict_types=1);

use App\Data\Validation\SignedIntegerData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], SignedIntegerData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 0],
    [true, 2147483647],
    [false, 2147483648],
    [false, -2147483649],
    [false, 'foo'],
    [false, ''],
]);
