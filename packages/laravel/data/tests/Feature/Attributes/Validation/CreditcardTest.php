<?php

declare(strict_types=1);

use App\Data\Validation\CreditcardData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], CreditcardData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, '4444111122223333'],
    [false, '9182819264532375'],
    [false, '12'],
    [false, '5555111122223333'],
    [false, 'xxxxxxxxxxxxxxxx'],
    [false, '4444111I22223333'],
]);
