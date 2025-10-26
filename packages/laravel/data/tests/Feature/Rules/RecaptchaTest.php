<?php

declare(strict_types=1);

use Honed\Data\Rules\Recaptcha;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Recaptcha('127.0.0.1');
});

it('calls api', function () {
    expect($this->rule->isValid('test'))->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => 'test',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe('validation::validation.recaptcha')
        );
});
