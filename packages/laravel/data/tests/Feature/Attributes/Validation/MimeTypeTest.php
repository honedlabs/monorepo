<?php

declare(strict_types=1);

use App\Data\Validation\MimeTypeData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], MimeTypeData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'application/pdf'],
    [true, 'application/zip'],
    [true, 'image/jpeg'],
    [true, 'image/svg+xml'],
    [true, 'multipart/form-data'],
    [true, 'application/octet-stream'],
    [true, 'font/woff'],
    [true, 'model/vrml'],
    [true, 'video/mp4'],
    [true, 'audio/mpeg'],
    [true, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
    [false, 'foo/bar'],
    [false, 'foo/jpeg'],
    [false, '/foo'],
    [false, 'image'],
    [false, 'foo'],
]);
