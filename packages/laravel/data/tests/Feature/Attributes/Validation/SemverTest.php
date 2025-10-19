<?php

declare(strict_types=1);

use App\Data\Validation\SemverData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], SemverData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, '1.0.0'],
    [true, '0.0.0'],
    [true, '3.2.1'],
    [true, '1.0.0-alpha'],
    [true, '1.0.0-alpha.1'],
    [true, '1.0.0-alpha1'],
    [true, '1.0.0-1'],
    [true, '1.0.0-0.3.7'],
    [true, '1.0.0-x.7.z.92'],
    [true, '1.0.0+20130313144700'],
    [true, '1.0.0-beta+exp.sha.5114f85'],
    [true, '1000.1000.1000'],
    [false, '1'],
    [false, '1.0'],
    [false, 'v1.0.0'],
    [false, '1.0.0.0'],
    [false, 'x.x.x'],
    [false, '1.x.x'],
    [false, '10.0.0.beta'],
    [false, 'foo'],
]);
