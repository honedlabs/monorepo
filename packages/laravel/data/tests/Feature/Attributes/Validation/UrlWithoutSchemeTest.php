<?php

declare(strict_types=1);

use App\Data\Validation\UrlWithoutSchemeData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'test' => $input,
    ], UrlWithoutSchemeData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    ['facebook.com', true],
    ['http://facebook.com', true],
    ['http://www.facebook.com', true],
    ['https://facebook.com', true],
    ['https://www.facebook.com', true],
    ['ftp://www.facebook.com', true],
    ['facebook.com/', true],
    ['http://facebook.com/', true],
    ['http://www.facebook.com/', true],
    ['https://facebook.com/', true],
    ['https://www.facebook.com/', true],
    ['ftp://www.facebook.com/', true],
    ['facebook.com/123', true],
    ['http://facebook.com/123', true],
    ['http://www.facebook.com/123', true],
    ['https://facebook.com/123', true],
    ['https://www.facebook.com/123', true],
    ['ftp://www.facebook.com/123', true],
    // ['', false],
    ['1', false],
    ['http://1', false],
    ['https://1', false],
]);
