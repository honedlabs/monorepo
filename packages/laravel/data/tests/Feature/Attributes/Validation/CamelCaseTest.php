<?php

declare(strict_types=1);

use App\Data\CamelCaseData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function ($input, bool $expected) {
    expect(Validator::make([
        'name' => $input,
    ], CamelCaseData::getValidationRules([
        'name' => $input
    ])))->passes()->toBe($expected);
})->with([
    'camel' => ['testName', true],
    'kebab' => ['test-name', false],
    'snake' => ['test_name', false],
    'studly' => ['TestName', true],
    'numeric' => ['123', false],
    'non-string' => [1, false],
]);