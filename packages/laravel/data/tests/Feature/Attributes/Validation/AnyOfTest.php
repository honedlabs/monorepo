<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\AnyOf;
use Honed\Data\Rules\Vimeo;
use Honed\Data\Rules\Youtube;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class() extends Data
    {
        public function __construct(
            #[AnyOf(Vimeo::class, Youtube::class)]
            public mixed $value
        ) {}
    };
});

// it('validates', function (mixed $input, bool $expected) {
//     expect(Validator::make([
//         'value' => $input,
//     ], $this->data::getValidationRules([
//         'value' => $input,
//     ])))->passes()->toBe($expected);
// })->with([
// ]);
