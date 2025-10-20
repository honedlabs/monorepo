<?php

declare(strict_types=1);

use App\Data\CacheData;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->freezeTime();
});

afterEach(function () {
    cache()->flush();
});

it('skips if not a request', function () {
    expect(CacheData::from(new stdClass()))
        ->test->toBeNull();
});

it('provides parameter', function (mixed $value) {
    $request = Request::create('/', Request::METHOD_POST);

    expect(CacheData::from($request)->test)
        ->toBe($value);
})->with([
    function () {
        cache(['test' => 'test']);

        return 'test';
    },
    function () {
        cache(['_test' => 'test']);

        return null;
    },
    function () {
        cache(['test' => 'test']);
        cache()->forget('test');

        return null;
    },
    function () {
        cache()->remember('test', 10, function () {
            return 'test';
        });

        $this->travel(9)->seconds();

        return 'test';
    },
    function () {
        cache()->remember('test', 10, function () {
            return 'test';
        });

        $this->travel(11)->seconds();

        return null;
    },
    function () {
        $this->freezeTime();

        cache()->flexible('test', [10, 20], 'value-1');

        $this->travel(11)->seconds();

        cache()->flexible('test', [10, 20], 'value-2');

        defer()->invoke();

        return 'value-2';
    },
]);
