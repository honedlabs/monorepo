<?php

declare(strict_types=1);

use Honed\Data\Rules\BitcoinAddress;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new BitcoinAddress();
});

it('validates', function (mixed $input, bool $expected) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    ['bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq', true],
    ['1bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq', false],
    ['12345678', false],
    ['', false],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 'bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => '1bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe('validation::validation.bitcoin_address')
        );
});
