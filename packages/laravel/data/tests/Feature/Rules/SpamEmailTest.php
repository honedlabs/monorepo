<?php

declare(strict_types=1);

use Honed\Data\Rules\SpamEmail;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new SpamEmail();
});

it('validates', function (mixed $input, bool $expected) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    ['user@gmail.com', true],
    ['test@outlook.com', true],
    ['name@yahoo.com', true],
    ['info@example.com', true],
    ['contact@laravel.com', true],
    ['user@mail.example.com', true],
    ['username@', true], // not validated, use 'email' rule instead
    ['@domain.com', true], // not validated, use 'email' rule instead
    ['test@0-mail.com', false],
    ['temp@10minutemail.com', false],
    ['junk@mailinator.com', false],
    ['spam@guerrillamail.com', false],
    ['fake@tempmail.co', false],
    ['disposable@throwawaymail.com', false],
    ['not an email', false],
    ['username', false],
    ['', false],
    [1, false],
    [0, false],
    [[], false],
    [null, false],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 'test@example.com',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => 'test@0-mail.com',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe('validation::validation.spam_email')
        );
});
