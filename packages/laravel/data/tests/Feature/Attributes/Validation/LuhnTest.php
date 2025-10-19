<?php

declare(strict_types=1);

use App\Data\Validation\LuhnData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], LuhnData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, '4444111122223333'],
    [true, '9501234400008'],
    [true, '446667651'],
    [true, 446667651],
    [false, '9182819264532375'],
    [false, '12'],
    [false, '5555111122223333'],
    [false, 'xxxxxxxxxxxxxxxx'],
    [false, '4444111I22223333'],
]);
