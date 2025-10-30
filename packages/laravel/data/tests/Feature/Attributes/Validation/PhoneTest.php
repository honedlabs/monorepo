<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\Phone;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class() extends Data
    {
        #[Phone('AU')]
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
    ['0412345678', true],
    ['04123456789', false],
    ['+61412345678', true],
    ['+614123456789', false],
]);
