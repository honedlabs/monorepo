<?php

declare(strict_types=1);

use App\Data\Validation\SnakecaseData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], SnakecaseData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'foo'],
    [true, 'foo_bar'],
    [true, 'foo_bar_baz'],
    [true, 'foo_bar_bâz'],
    [false, 'foo-bar'],
    [false, 'foo_'],
    [false, '_foo'],
    [false, '_foo-'],
    [false, 'fooBar'],
    [false, 'Foo_bar'],
    [false, 'foo_baR'],
]);
