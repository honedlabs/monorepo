<?php

declare(strict_types=1);

use App\Data\Validation\LongitudeData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], LongitudeData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, '0'],
    [true, '+90'],
    [true, '-90'],
    [true, '90'],
    [true, '+90.0000001'],
    [true, '-90.0000001'],
    [true, '90.00000001'],
    [true, '+180'],
    [true, '-180'],
    [true, '180'],
    [false, '180.0001'],
    [false, '-180.0001'],
]);
