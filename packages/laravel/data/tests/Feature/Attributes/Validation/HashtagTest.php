<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\Hashtag;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class() extends Data
    {
        #[Hashtag]
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
    ['#hashtag', true],
    ['#hashtag_with_underscores', true],
    ['#', true],
    ['hashtag', false],
    ['#hashtag with spaces', false],
    [1, false],
    ['a', false],
]);
