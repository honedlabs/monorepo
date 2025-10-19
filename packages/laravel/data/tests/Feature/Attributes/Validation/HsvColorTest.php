<?php

declare(strict_types=1);

use App\Data\Validation\HsvColorData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], HsvColorData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'hsv(20, 100, 50)'],
    [true, 'hsv(20, 100%, 50%)'],
    [true, 'hsv(0, 100%, 50%)'],
    [true, 'hsv(0, 0%, 0%)'],
    [true, 'hsv(0,0%,0%)'],
    [true, 'hsv(0,0,0)'],
    [true, 'HSV(0,0,0)'],
    [true, 'hsv(360, 100%, 100%)'],
    [true, 'hsb(20, 100, 50)'],
    [true, 'hsb(20, 100%, 50%)'],
    [true, 'hsb(0, 100%, 50%)'],
    [true, 'hsb(0, 0%, 0%)'],
    [true, 'hsb(0,0%,0%)'],
    [true, 'hsb(0,0,0)'],
    [true, 'HSB(0,0,0)'],
    [true, 'hsb(360, 100%, 100%)'],
    [false, 'hsv(361, 101%, 101%)'],
    [false, 'hsv(-1, 0%, 0%)'],
    [false, 'hsb(361, 101%, 101%)'],
    [false, 'hsb(-1, 0%, 0%)'],
    [false, ''],
]);
