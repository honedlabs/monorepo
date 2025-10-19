<?php

declare(strict_types=1);

use App\Data\Validation\LatitudeData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], LatitudeData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, '-80'],
    [true, '0'],
    [true, '+50'],
    [true, '90'],
    [true, '-19.123'],
    [true, '0.11111'],
    [true, '+89.00000'],
    [true, '0.00000'],
    [true, '+89.00000'],
    [true, '89.99999'],
    [true, '90'],
    [true, '-90'],
    [false, '91'],
    [false, '-91'],
    [false, '90.000001'],
    [false, '-90.000001'],
]);
