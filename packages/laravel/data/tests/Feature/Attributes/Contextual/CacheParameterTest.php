<?php

declare(strict_types=1);

use App\Classes\GetCache;

beforeEach(function () {
    $this->freezeTime();
});

afterEach(function () {
    cache()->flush();
});

it('provides parameter', function (mixed $value) {
    $test = app()->make(GetCache::class)->get();

    expect($test)->toBe($value);
})->skip(function () {
    return (float) app()->version() < 12.0;
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
        if (! method_exists(cache()->driver(), 'flexible')) {
            return 'test';
        }

        $this->freezeTime();

        cache()->flexible('test', [10, 20], 'value-1');

        $this->travel(11)->seconds();

        cache()->flexible('test', [10, 20], 'value-2');

        defer()->invoke();

        return 'value-2';
    },
]);
