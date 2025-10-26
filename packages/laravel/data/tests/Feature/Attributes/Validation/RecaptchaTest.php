<?php

declare(strict_types=1);

use App\Data\Validation\RecaptchaData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'value' => $input,
    ], RecaptchaData::getValidationRules([
        'value' => $input,
    ])))->passes()->toBe($expected);
})->with([
    ['test', false],
]);
