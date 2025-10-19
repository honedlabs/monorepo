<?php

declare(strict_types=1);

use App\Classes\GetSession;

beforeEach(function () {});

it('provides parameter', function (mixed $value) {
    $test = app()->make(GetSession::class)->get();

    expect($test)->toBe($value);
})->skip(function () {
    return (float) app()->version() < 12.0;
})->with([
    function () {
        session()->put('test', 'test');

        return 'test';
    },
    function () {
        session()->put('_test', 'test');

        return null;
    },
    function () {
        session()->put('test', 'test');

        session()->forget('test');

        return null;
    },
]);
