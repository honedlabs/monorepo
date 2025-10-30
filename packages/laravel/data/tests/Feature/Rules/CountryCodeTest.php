<?php

declare(strict_types=1);

use Honed\Data\Rules\CountryCode;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new CountryCode();
});

it('validates', function (bool $expected, string $input) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    [true, 'AU'],
    [true, 'US'],
    [false, 'USD'],
    [false, ''],
    [false, '1'],
    [false, 'us'],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 'US',
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
            ->toBe(__('honed-data::validation.country_code', ['attribute' => 'value']))
        );
});
