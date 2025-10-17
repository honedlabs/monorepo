<?php

declare(strict_types=1);

use App\Data\CamelcaseData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function ($input, bool $expected) {
    expect(Validator::make([
        'test' => $input,
    ], CamelcaseData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    ['foo', true],
    ['Foo', true],
    ['fooBar', true],
    ['fooBarBaz', true],
    ['fooBarBâz', true],
    ['fOo', true],
    ['PostScript', true],
    ['iPhone', true],
    ['foobaR', false],
    ['FoobaR', false],
    ['FOo', false],
    ['FOO', false],
    ['fo0bar', false],
    ['-fooBar', false],
    ['-fooBar-', false],
]);
