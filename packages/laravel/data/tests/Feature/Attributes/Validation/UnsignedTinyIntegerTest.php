<?php

declare(strict_types=1);

use App\Data\Validation\UnsignedTinyIntegerData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], UnsignedTinyIntegerData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 0],
    [true, 255],
    [false, 256],
    [false, -1],
    [false, 'foo'],
    [false, ''],
]);
