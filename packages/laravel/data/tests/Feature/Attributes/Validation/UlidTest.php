<?php

declare(strict_types=1);

use App\Data\Validation\UlidData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], UlidData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, '01B8KYR6G8BC61CE8R6K2T16HY'],
    [true, '01b8kyr6g8bc61ce8r6k2t16hy'],
    [true, '01EBMHP6H7TT1Q4B7CA018K5MQ'],
    [true, '01AN4Z07BY79KA1307SR9X4MV3'],
    [true, '01BJ3J678K844ZTW53YPNB5K54'],
    [true, '7ZZZZZZZZZT103WW4FN24H45Y7'],
    [true, '7ZZZZZZZZZZZZZZZZZZZZZZZZZ'],
    [false, 'bar'],
    [false, 'bar'],
    [false, '01AN4Z07BY79KA1307SR9X4MV3F'],
    [false, '01AN4Z07BY79KA1307SR9X4MV'],
    [false, '01AN4ZÖ7BY79KA1307SR9X4MV3'],
    [false, '01AN4ZL7BY79KA1307SR9X4MV3'],
    [false, '01AN4Z_7BY79KA1307SR9X4MV3'],
    [false, '8ZZZZZZZZZZZZZZZZZZZZZZZZZ'],
]);
