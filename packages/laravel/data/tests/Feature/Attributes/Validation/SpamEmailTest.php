<?php

declare(strict_types=1);

use App\Data\Validation\SpamEmailData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'test' => $input,
    ], SpamEmailData::getValidationRules([
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
