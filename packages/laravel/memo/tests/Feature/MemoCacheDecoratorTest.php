<?php

declare(strict_types=1);

use App\Stores\NoLockStore;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Exceptions;

beforeEach(function () {});

it('memoizes', function () {
    expect(app('cache'))
        ->put('key', 'value-1', 60)->toBeTrue()
        ->get('key')->toBe('value-1')
        ->isMemoized('key')->toBeTrue()
        ->put('key', 'value-2', 60)->toBeTrue()
        ->get('key')->toBe('value-2')
        ->isMemoized('key')->toBeTrue();
});

it('supports null values', function () {
    expect(app('cache'))
        ->get('key')->toBeNull()
        ->isMemoized('key')->toBeTrue()
        ->put('key', 'value-1', 60)->toBeTrue()
        ->get('key')->toBe('value-1')
        ->isMemoized('key')->toBeTrue()
        ->put('key', null, 60)->toBeTrue()
        ->get('key')->toBeNull()
        ->isMemoized('key')->toBeTrue();
});

it('supports multiple values', function () {
    expect(app('cache'))
        ->put('key-1', 'value-1', 60)->toBeTrue()
        ->put('key-2', 'value-2', 60)->toBeTrue()
        ->getMultiple(['key-1', 'key-2'])->toEqualCanonicalizing([
            'key-1' => 'value-1',
            'key-2' => 'value-2',
        ])
        ->isMemoized('key-1')->toBeTrue()
        ->isMemoized('key-2')->toBeTrue()
        ->getMultiple(['key-1', 'key-2'])->toEqualCanonicalizing([
            'key-1' => 'value-1',
            'key-2' => 'value-2',
        ])
        ->isMemoized('key-1')->toBeTrue()
        ->isMemoized('key-2')->toBeTrue();
});

it('forgets when incrementing', function () {
    expect(app('cache'))
        ->put('count', 1, 60)->toBeTrue()
        ->isMemoized('count')->toBeFalse()
        ->get('count')->toBe(1)
        ->isMemoized('count')->toBeTrue()
        ->increment('count')->toBe(2)
        ->get('count')->toBe(2)
        ->isMemoized('count')->toBeTrue();
});

it('forgets when decrementing', function () {
    expect(app('cache'))
        ->put('count', 1, 60)->toBeTrue()
        ->isMemoized('count')->toBeFalse()
        ->get('count')->toBe(1)
        ->isMemoized('count')->toBeTrue()
        ->decrement('count')->toBe(0)
        ->isMemoized('count')->toBeFalse()
        ->get('count')->toBe(0);
});

it('forgets when forever', function () {
    expect(app('cache'))
        ->put('key', 'value-1', 60)->toBeTrue()
        ->isMemoized('key')->toBeFalse()
        ->get('key')->toBe('value-1')
        ->isMemoized('key')->toBeTrue()
        ->forever('key', 'value-2')->toBeTrue()
        ->isMemoized('key')->toBeFalse()
        ->get('key')->toBe('value-2');
});

it('forgets when forgetting', function () {
    expect(app('cache'))
        ->put('key', 'value-1', 60)->toBeTrue()
        ->isMemoized('key')->toBeFalse()
        ->get('key')->toBe('value-1')
        ->isMemoized('key')->toBeTrue()
        ->forget('key')->toBeTrue()
        ->isMemoized('key')->toBeFalse()
        ->get('key')->toBeNull();
        // ->isMemoized('key')->toBeFalse();
});

it('forgets when flushing', function () {
    expect(app('cache'))
        ->put('key', 'value-1', 60)->toBeTrue()
        ->isMemoized('key')->toBeFalse()
        ->get('key')->toBe('value-1')
        ->isMemoized('key')->toBeTrue()
        ->flush()->toBeTrue()
        ->isMemoized('key')->toBeFalse()
        ->get('key')->toBeNull();
        // ->isMemoized('key')->toBeFalse();
});

it('uses store prefix', function () {
    expect(app('cache'))
        ->getPrefix()->toBe('laravel_cache_');

    app('cache')->driver('redis')->setPrefix('foo');

    expect(app('cache')->getPrefix())->toBe('foo');
})->todo();

it('prefixes keys', function () {

})->todo();

it('dispatches events', function () {

})->todo();

it('throws when store does not support locks', function () {
    $this->freezeTime();

    $exception = [];

    Exceptions::reportable(function (Throwable $e) use (&$exception) {
        $exception = $e;
    });

    Config::set('cache.stores.no-lock', ['driver' => 'no-lock']);

    app('cache')->extend('no-lock', fn () => Cache::repository(new NoLockStore()));

    app('cache')->flexible('key', [10, 20], 'value-1');

    defer()->invoke();

    $value = app('cache')->get('key');

    expect($exception)
        ->toHaveCount(1)
        ->{0}->toBeInstanceOf(BadMethodCallException::class);

})->skip();

it('supports flexible', function () {
    $this->freezeTime();

    app('cache')->flexible('key', [10, 20], 'value-1');

    $this->travel(11)->seconds();

    app('cache')->flexible('key', [10, 20], 'value-2');

    defer()->invoke();

    expect(app('cache'))
        ->get('key')->toBe('value-2');
});