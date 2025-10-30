<?php

declare(strict_types=1);

use Honed\Data\Rules\Odd;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Odd();
});

it('validates', function (mixed $input, bool $expected) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    [2, false],
    [2.65, false],
    [0, false],
    [-2, false],
    [-2.65, false],
    [1, true],
    [1.65, true],
    [-1, true],
    [-1.65, true],
    [0.65, false],
    [-0.65, false],
    ['', false],
    ['a', false],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 1,
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => 2,
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe(__('honed-data::validation.odd', ['attribute' => 'value']))
        );
});
