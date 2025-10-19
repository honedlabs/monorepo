<?php

declare(strict_types=1);

use App\Data\Validation\UsernameData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], UsernameData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'tom'],
    [true, 'tester'],
    [true, 'test12'],
    [true, 't-e-s-t'],
    [true, 'mr_freeze'],
    [true, 'mr-freeze'],
    [true, 'r00t'],
    [true, 'theQuickBrownFoxJump'],
    [true, 'mr'],
    [true, 'x'],
    [true, 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],
    [true, 'theQuickBrownFoxJumps'],
    [false, 'homer-'],
    [false, '-homer'],
    [false, 'homer_'],
    [false, '_homer'],
    [false, '_homer_'],
    [false, '1homer'],
    [false, ' homer'],
    [false, 'o__o'],
    [false, 'mr.freeze'],
    [false, 'mr freeze'],
    [false, '-mr-freeze'],
    [false, '1337'],
    [false, '-91819'],
    [false, '&nbsp;'],
    [false, '<html></html>'],
    [false, '-_homer_-'],
    [false, '1mo'],
    [false, '_test_'],
    [false, '04420'],
    [false, 'array()'],
    [false, '$234_&'],
    [false, '?test=1'],
    [false, '€uro'],
    [false, 'ⓣⓔⓢⓣ'],
    [false, '𝒕𝒆𝒔𝒕'],
]);
