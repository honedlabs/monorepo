<?php

declare(strict_types=1);

use Honed\Data\Rules\Currency;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Currency();
});

it('validates', function (bool $expected, string $input) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    [true, 'USD'],
    [true, 'EUR'],
    [true, 'AUD'],
    [false, 'JDW'],
    [false, ''],
    [false, '1'],
    [false, 'usd'],
    [false, 'us'],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 'USD',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => 'us',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe('validation::validation.currency')
        );
});
