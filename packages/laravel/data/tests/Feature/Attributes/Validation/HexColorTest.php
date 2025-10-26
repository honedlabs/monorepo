<?php

declare(strict_types=1);

use App\Data\Validation\HexColorData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

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
    [false, 'abc'],
    [false, 'abcabc'],
    [false, 'abcabcab'],
    [false, 'b33517'],
    [false, 'b33517ff'],
    [false, 'ccc'],
    [false, 'ffff'],
    [false, 'f00'],
    [false, 'f000'],
]);
