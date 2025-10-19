<?php

declare(strict_types=1);

use App\Data\Validation\SignedSmallIntegerData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], SignedSmallIntegerData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, -32768],
    [true, 32767],
    [true, 0],
    [false, 32768],
    [false, -32769],
    [false, 'foo'],
    [false, ''],
]);
