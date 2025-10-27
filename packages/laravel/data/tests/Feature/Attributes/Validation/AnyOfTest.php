<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\AnyOf;
use Honed\Data\Rules\Vimeo;
use Honed\Data\Rules\Youtube;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class() extends Data
    {
        #[AnyOf(new Vimeo(), new Youtube())]
        public mixed $value;
    };
})->skip(fn () => ! method_exists(Rule::class, 'anyOf'));

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'value' => $input,
    ], $this->data::getValidationRules([
        'value' => $input,
    ])))->passes()->toBe($expected);
})->with([
    ['https://vimeo.com/123456789', true],
    ['https://www.youtube.com/watch?v=dQw4w9WgXcQ', true],
    ['not-a-url', false],
]);
