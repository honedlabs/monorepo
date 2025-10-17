<?php

declare(strict_types=1);

use Honed\Data\Rules\Scalar;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Scalar();
});

it('validates', function ($input, bool $expected) {
    expect($this->rule) 
        ->isValid($input)->toBe($expected);
})->with([
    'numeric' => [1, true],
    'string' => ['test', true],
    'boolean' => [true, true],
    'null' => [null, false],
    'object' => [new stdClass(), false],
    'array of numerics' => [[1, 2], true],
    'array of strings' => [['1', '2'], true],
    'array of booleans' => [[true, false], true],
    'array of nulls' => [[null, null], false],
    'array of objects' => [[1, new stdClass()], false],
    'array of arrays' => [[[1, 2, 3], [4, 5, 6]], false],
    'array of mixed' => [[1, 'test', true], true],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => [1, 2, 3],
    ], [
        'value' => [new Scalar()],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => new stdClass(),
    ], [
        'value' => [new Scalar()],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe('validation::validation.scalar')
        );
});