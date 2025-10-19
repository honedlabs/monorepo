<?php

declare(strict_types=1);

use App\Data\Validation\TitlecaseData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], TitlecaseData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'Foo'],
    [true, 'FooBar'],
    [true, 'Foo Bar'],
    [true, 'F Bar'],
    [true, '6 Bar'],
    [true, 'FooBar Baz'],
    [true, 'Foo Bar Baz'],
    [true, 'Foo-Bar Baz'],
    [true, 'Ba_r Baz'],
    [true, 'F00 Bar Baz'],
    [true, 'Ês Üm Ñõ'],
    [false, 'foo'],
    [false, 'Foo '],
    [false, ' Foo'],
    [false, 'Foo bar'],
    [false, 'foo bar'],
    [false, 'Foo Bar baz'],
    [false, 'Foo bar baz'],
    [false, '-fooBar'],
    [false, '-fooBar-'],
    [false, 'The quick brown fox jumps over the lazy dog.'],
]);
