<?php

declare(strict_types=1);

use App\Data\Validation\HslColorData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], HslColorData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'hsl(20, 100, 50)'],
    [true, 'hsl(20, 100%, 50%)'],
    [true, 'hsl(0, 100%, 50%)'],
    [true, 'hsl(0, 0%, 0%)'],
    [true, 'hsl(0,0%,0%)'],
    [true, 'hsl(0,0,0)'],
    [true, 'HSL(0,0,0)'],
    [true, 'hsl(360, 100%, 100%)'],
    [false, 'hsl(361, 101%, 101%)'],
    [false, 'hsl(-1, 0%, 0%)'],
    [false, ''],
]);
