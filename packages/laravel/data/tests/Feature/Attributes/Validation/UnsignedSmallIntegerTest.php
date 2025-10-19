<?php

declare(strict_types=1);

use App\Data\Validation\UnsignedSmallIntegerData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], UnsignedSmallIntegerData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 0],
    [true, 65535],
    [false, 65536],
    [false, -1],
    [false, 'foo'],
    [false, ''],
]);
