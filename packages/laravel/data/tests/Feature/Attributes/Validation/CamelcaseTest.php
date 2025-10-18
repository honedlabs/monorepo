<?php

declare(strict_types=1);

use App\Data\Validation\CamelcaseData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->artisan('data:cache-structures');
})->only();

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], CamelcaseData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'foo'],
    [true, 'Foo'],
    [true, 'fooBar'],
    [true, 'fooBarBaz'],
    [true, 'fooBarBâz'],
    [true, 'fOo'],
    [true, 'PostScript'],
    [true, 'iPhone'],
    [false, 'foobaR'],
    [false, 'FoobaR'],
    [false, 'FOo'],
    [false, 'FOO'],
    [false, 'fo0bar'],
    [false, '-fooBar'],
    [false, '-fooBar-'],
]);
