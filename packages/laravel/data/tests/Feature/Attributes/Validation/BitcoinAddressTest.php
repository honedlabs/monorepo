<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\BitcoinAddress;
use Honed\Data\Attributes\Validation\Recaptcha;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class() extends Data
    {
        #[BitcoinAddress]
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
    ['bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq', true],
    ['1bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq', false],
    ['12345678', false],
]);
