<?php

declare(strict_types=1);

use Honed\Data\Rules\MaxWords;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new MaxWords(2);
});

it('validates', function (mixed $input, bool $expected) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    ['one', true],
    ['one two', true],
    ['one two three', false],
    [5, true],
    ['', true],
    ['one-two-three', true],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 'one',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => 'one two three',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe('validation::validation.max_words')
        );
});
