<?php

declare(strict_types=1);

use Honed\Data\Rules\Country;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Country();
});

it('validates', function (mixed $input, bool $expected) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    ['Australia', true],
    ['United States of America', true],
    ['United States', false],
    ['Queensland', false],
    ['', false],
    ['1', false],
    ['Aus', false],
    ['US', false],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 'Australia',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => 'Queensland',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe(__('honed-data::validation.country', ['attribute' => 'value']))
        );
});
