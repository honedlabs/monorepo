<?php

declare(strict_types=1);

use App\Data\Validation\CurrencyData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'value' => $input,
    ], CurrencyData::getValidationRules([
        'value' => $input,
    ])))->passes()->toBe($expected);
})->with([
    ['USD', true],
    ['EUR', true], 
    ['AUD', true],
    ['JDW', false],
    ['1', false],
    ['usd', false],
    ['us', false],
]);
