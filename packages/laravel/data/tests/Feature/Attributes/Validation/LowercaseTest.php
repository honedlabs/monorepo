<?php

declare(strict_types=1);

use App\Data\Validation\LowercaseData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], LowercaseData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'a'],
    [true, 'abc'],
    [true, 'ß'],
    [true, 'êçã'],
    [true, 'valid'],
    [true, 'foo bar'],
    [true, 'foo-bar'],
    [true, '!'],
    [true, '?'],
    [true, '9'],
    [true, '#'],
    [false, 'A'],
    [false, 'ABC'],
    [false, 'Ä'],
    [false, 'ÄÖÜ'],
    [false, 'VALID'],
    [false, 'ÇÃÊ'],
]);
