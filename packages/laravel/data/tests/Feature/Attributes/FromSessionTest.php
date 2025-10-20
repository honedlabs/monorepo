<?php

declare(strict_types=1);

use App\Data\SessionData;
use Illuminate\Http\Request;

beforeEach(function () {});

it('skips if not a request', function () {
    expect(SessionData::from(new stdClass()))
        ->test->toBeNull();
});

it('provides parameter', function (mixed $value) {
    $request = Request::create('/', Request::METHOD_POST);

    expect(SessionData::from($request)->test)
        ->toBe($value);
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
