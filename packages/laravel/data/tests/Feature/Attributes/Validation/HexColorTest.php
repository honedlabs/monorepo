<?php

declare(strict_types=1);

use App\Data\Validation\HexColorData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {})->skip();

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], HexColorData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [false, '#'],
    [false, 'f'],
    [false, 'ff'],
    [false, 'x25s11'],
    [false, 'fffffffff'],
    [true, '#ccc'],
    [true, '#cccccc'],
    [true, '#ffff'],
    [true, '#ffffffff'],
    [true, 'abc'],
    [true, 'abcabc'],
    [true, 'abcabcab'],
    [true, 'b33517'],
    [true, 'b33517ff'],
    [true, 'ccc'],
    [true, 'ffff'],
    [true, 'f00'],
    [true, 'f000'],
]);
