<?php

declare(strict_types=1);

use App\Data\Validation\KebabcaseData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], KebabcaseData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'foo'],
    [true, 'foo-bar'],
    [true, 'foo-bar-baz'],
    [true, 'foo-bar-bâz'],
    [false, 'foo_bar'],
    [false, 'foo-'],
    [false, '-foo'],
    [false, '-foo-'],
    [false, 'fooBar'],
    [false, 'Foo-bar'],
    [false, 'foo-baR'],
]);
