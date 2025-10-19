<?php

declare(strict_types=1);

use App\Classes\GetCache;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {})->only();

afterEach(function () {
    cache()->flush();
});

it('provides parameter', function (mixed $value) {
    $test = app()->make(GetCache::class)->get();

    expect($test)->toBe($value);
})
->with([
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
        $this->freezeTime();

        cache()->remember('test', 60, function () {
            return 'test';
        });

        return 'test';
    },
    function () {
        $this->freezeTime();

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
