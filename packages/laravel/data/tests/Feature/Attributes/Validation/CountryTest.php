<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\Country;
use Honed\Data\Attributes\Validation\Recaptcha;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class() extends Data
    {
        #[Country]
        public mixed $value;
    };
});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'value' => $input,
    ], $this->data::getValidationRules([
        'value' => $input,
    ])))->passes()->toBe($expected);
})->with([
    ['Australia', true],
    ['United States of America', true],
    ['United States', false],
    ['Queensland', false],
    ['1', false],
    ['Aus', false],
    ['US', false],
]);
