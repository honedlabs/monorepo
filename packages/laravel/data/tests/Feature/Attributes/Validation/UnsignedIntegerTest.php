<?php

declare(strict_types=1);

use App\Data\Validation\UnsignedIntegerData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], UnsignedIntegerData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 0],
    [true, 4294967295],
    [false, 4294967296],
    [false, -1],
    [false, 'foo'],
    [false, ''],
]);
