<?php

declare(strict_types=1);

use Honed\Data\Rules\DisposableEmail;
use Honed\Data\Rules\Whitespace;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Whitespace();
});

it('validates', function (mixed $input, bool $expected) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    ['valid', true],
    ['valid_string', true],
    ['valid-string', true],
    ['', true],
    [' ', false],
    ['invalid string', false],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 'valid_string',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => 'invalid string',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe(__('honed-data::validation.whitespace', ['attribute' => 'value']))
        );
});
