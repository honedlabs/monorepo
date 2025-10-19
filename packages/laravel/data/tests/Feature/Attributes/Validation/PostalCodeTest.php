<?php

declare(strict_types=1);

use App\Data\Validation\PostalCodeData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], PostalCodeData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'A9 9AA'],
    [true, 'A99 9AA'],
    [true, 'A9A 9AA'],
    [true, 'AA9 9AA'],
    [true, 'AA99 9AA'],
    [true, 'AA9A 9AA'],
    [true, 'a9 9aa'],
    [true, 'a99 9aa'],
    [true, 'a9a 9aa'],
    [true, 'aa9 9aa'],
    [true, 'aa99 9aa'],
    [true, 'aa9a 9aa'],
    [false, 'A99AA'],
    [false, 'A999AA'],
    [false, 'A9A9AA'],
    [false, 'AA99AA'],
    [false, 'AA999AA'],
    [false, 'AA9A9AA'],
    [false, 'A9-9AA'],
    [false, 'A99-9AA'],
    [false, 'A9A-9AA'],
    [false, 'AA9-9AA'],
    [false, 'AA99-9AA'],
    [false, 'AA9A-9AA'],
    [false, '99 9AA'],
    [false, '999 9AA'],
    [false, 'AAA 9AA'],
    [false, '9A9 9AA'],
    [false, '99AA 9AA'],
    [false, 'A9AA 9AA'],
    [false, '123'],
    [false, '1234'],
    [false, '12345'],
    [false, '123456'],
]);
