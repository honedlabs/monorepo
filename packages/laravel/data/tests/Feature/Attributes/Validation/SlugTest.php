<?php

declare(strict_types=1);

use App\Data\Validation\SlugData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], SlugData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'foo'],
    [true, 'foo-bar'],
    [true, 'foo-bar-baz'],
    [true, 'Foo-Bar'],
    [true, 'FOO-BAR'],
    [true, 'FOO-123'],
    [true, '1-3'],
    [true, 'f'],
    [true, 'f-o-o'],
    [true, '0'],
    [false, '-foo'],
    [false, 'foo-'],
    [false, '-foo-bar-'],
    [false, 'f--o'],
    [false, '-'],
    [false, 'foo bar'],
    [false, 'foo%20bar'],
    [false, 'foo+bar'],
    [false, 'foo_bar'],
    [false, 'foo '],
    [false, ' foo'],
    [false, '?'],
    [false, 'föö'],
]);
