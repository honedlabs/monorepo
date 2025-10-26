<?php

declare(strict_types=1);

use App\Data\Validation\CountryCodeData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'value' => $input,
    ], CountryCodeData::getValidationRules([
        'value' => $input,
    ])))->passes()->toBe($expected);
})->with([
    ['AU', true],
    ['US', true], 
    ['USD', false],
    ['1', false],
    ['us', false],
]);
