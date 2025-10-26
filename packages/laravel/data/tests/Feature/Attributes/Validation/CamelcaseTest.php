<?php

declare(strict_types=1);

use App\Data\Validation\CamelcaseData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'value' => $input,
    ], CamelcaseData::getValidationRules([
        'value' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'foo'],
    // [true, 'Foo'],
    [true, 'fooBar'],
    // [true, 'fooBarBaz'],
    // [true, 'fooBarBâz'],
    // [true, 'fOo'],
    // [true, 'PostScript'],
    // [true, 'iPhone'],
    // [false, 'foobaR'],
    // [false, 'FoobaR'],
    // [false, 'FOo'],
    // [false, 'FOO'],
    // [false, 'fo0bar'],
    // [false, '-fooBar'],
    // [false, '-fooBar-'],
]);
