<?php

declare(strict_types=1);

use Honed\Data\Rules\Scalar;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Scalar();
});

it('validates', function (mixed $input, bool $expected) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    [1, true],
    ['test', true],
    [true, true],
    [null, false],
    [new stdClass(), false],
    [[1, 2], true],
    [['1', '2'], true],
    [[true, false], true],
    [[1, new stdClass()], false],
    [[[1, 2, 3], [4, 5, 6]], false],
    [[1, 'test', true], true],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => [1, 2, 3],
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => new stdClass(),
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe('validation::validation.scalar')
        );
});
