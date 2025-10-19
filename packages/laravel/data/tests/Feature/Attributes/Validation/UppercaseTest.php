<?php

declare(strict_types=1);

use App\Data\Validation\UppercaseData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], UppercaseData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'A'],
    [true, 'ABC'],
    [true, 'Ä'],
    [true, 'ÄÖÜ'],
    [true, 'VALID'],
    [true, 'ÇÃÊ'],
    [true, '123'],
    [true, 'A1'],
    [true, '_'],
    [true, '!'],
    [true, 'A-B'],
    [true, 'A B'],
    [true, '?'],
    [true, '#'],
    [true, 'FOO BAR'],
    [false, 'a'],
    [false, 'foo bar'],
    [false, 'fooß'],
    [false, 'abc'],
    [false, 'äöü'],
    [false, '(a)'],
]);
