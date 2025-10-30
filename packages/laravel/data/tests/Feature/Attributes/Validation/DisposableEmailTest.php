<?php

declare(strict_types=1);

use Honed\Data\Attributes\Validation\DisposableEmail;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class() extends Data
    {
        #[DisposableEmail]
        public string $test;
    };
});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'test' => $input,
    ], $this->data::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    ['user@gmail.com', true],
    ['test@outlook.com', true],
    ['name@yahoo.com', true],
    ['info@example.com', true],
    ['contact@laravel.com', true],
    ['user@mail.example.com', true],
    ['username@', false], // 'email' rule fails
    ['@domain.com', false], // 'email' rule fails
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
