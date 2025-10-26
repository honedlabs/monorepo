<?php

declare(strict_types=1);

use App\Data\Validation\ScalarData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'test' => $input,
    ], ScalarData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [1, true],
    ['test', true],
    [true, true],
    [new stdClass(), false],
    [[1, 2], true],
    [['1', '2'], true],
    [[true, false], true],
    [[null, null], false],
    [[1, new stdClass()], false],
    [[[1, 2, 3], [4, 5, 6]], false],
    [[1, 'test', true], true],
]);
