<?php

declare(strict_types=1);

use App\Data\Validation\CidrData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], CidrData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, '0.0.0.0/0'],
    [true, '10.0.0.0/8'],
    [true, '1.1.1.1/32'],
    [true, '192.168.1.0/24'],
    [true, '192.168.1.1/24'],
    [false, '192.168.1.1'],
    [false, '1.1.1.1/3.14'],
    [false, '1.1.1.1/33'],
    [false, '1.1.1.1/100'],
    [false, '1.1.1.1/-3'],
    [false, '1.1.1/3'],
]);
