<?php

declare(strict_types=1);

use Honed\Data\Rules\UrlWithoutScheme;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new UrlWithoutScheme();
});

it('validates', function (bool $expected, string $input) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    [true, 'facebook.com'],
    [true, 'http://facebook.com'],
    [true, 'http://www.facebook.com'],
    [true, 'https://facebook.com'],
    [true, 'https://www.facebook.com'],
    [true, 'ftp://www.facebook.com'],
    [true, 'facebook.com/'],
    [true, 'http://facebook.com/'],
    [true, 'http://www.facebook.com/'],
    [true, 'https://facebook.com/'],
    [true, 'https://www.facebook.com/'],
    [true, 'ftp://www.facebook.com/'],
    [true, 'facebook.com/123'],
    [true, 'http://facebook.com/123'],
    [true, 'http://www.facebook.com/123'],
    [true, 'https://facebook.com/123'],
    [true, 'https://www.facebook.com/123'],
    [true, 'ftp://www.facebook.com/123'],
    [false, ''],
    [false, '1'],
    [false, 'http://1'],
    [false, 'https://1'],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 'honed.dev',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => '1',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe(__('validation.url', ['attribute' => 'value']))
        );
});
