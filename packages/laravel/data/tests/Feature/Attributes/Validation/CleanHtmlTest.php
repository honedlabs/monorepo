<?php

declare(strict_types=1);

use App\Data\Validation\CleanHtmlData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], CleanHtmlData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, '123456'],
    [true, '1+2=3'],
    [true, 'The quick brown fox jumps over the lazy dog.'],
    [true, '>>>test'],
    [true, '>test'],
    [true, 'test>'],
    [true, 'attr="test"'],
    [true, 'one < two'],
    [true, 'two>one'],
    [false, 'The quick brown fox jumps <strong>over</strong> the lazy dog.'],
    [false, '<html>'],
    [false, '<HTML>test</HTML>'],
    [false, '<html attr="test">'],
    [false, 'Test</p>'],
    [false, 'Test</>'],
    [false, 'Test<>'],
    [false, '<0>'],
    [false, '<>'],
    [false, '><'],
]);
