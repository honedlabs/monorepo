<?php

declare(strict_types=1);

use Honed\Data\Rules\Even;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Even();
});

it('validates', function (mixed $input, bool $expected) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    [2, true],
    [2.65, true],
    [0, true],
    [-2, true],
    [-2.65, true],
    [1, false],
    [1.65, false],
    [-1, false],
    [-1.65, false],
    [0.65, true],
    [-0.65, true],
    ['', true],
    ['a', true],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 2,
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => 1,
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe(__('honed-data::validation.even', ['attribute' => 'value']))
        );
});
