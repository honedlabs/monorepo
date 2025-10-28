<?php

declare(strict_types=1);

use Honed\Data\Rules\Hashtag;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Hashtag();
})->only();

it('validates', function (mixed $input, bool $expected) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    ['#hashtag', true],
    ['#hashtag_with_underscores', true],
    ['#', true],
    ['hashtag', false],
    ['#hashtag with spaces', false],
    ['', false],
    [1, false],
    ['a', false],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => '#hashtag',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => 'hashtag',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe('validation::validation.hashtag')
        );
});
