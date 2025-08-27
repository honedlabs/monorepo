<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;

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
        // ->isMemoized('key')->toBeTrue()
        ->put('key', 'value-1', 60)->toBeTrue()
        ->get('key')->toBe('value-1')
        ->isMemoized('key')->toBeTrue()
        ->put('key', null, 60)->toBeTrue()
        ->get('key')->toBeNull()
        ->isMemoized('key')->toBeTrue();
});

it('supports multiple values', function () {
    Cache::put('key-1', 'value-1', 60);
    Cache::put('key-2', 'value-2', 60);


    expect(Cache::getMultiple(['key-1', 'key-2']))->toEqualCanonicalizing([
        'key-1' => 'value-1',
        'key-2' => 'value-2',
    ]);

    expect(Cache::isMemoized('key-1'))->toBeTrue();
    expect(Cache::isMemoized('key-2'))->toBeTrue();
});

it('forgets when incrementing', function () {
    Cache::put('count', 1, 60);

    expect(Cache::get('count'))->toBe(1);

    expect(Cache::isMemoized('count'))->toBeTrue();

    expect(Cache::increment('count'))->toBe(2);

    expect(Cache::isMemoized('count'))->toBeFalse();

    expect(Cache::get('count'))->toBe(2);

    expect(Cache::isMemoized('count'))->toBeTrue();
});

it('forgets when decrementing', function () {
    Cache::put('count', 1, 60);

    expect(Cache::get('count'))->toBe(1);

    expect(Cache::isMemoized('count'))->toBeTrue();

    expect(Cache::decrement('count'))->toBe(0);

    expect(Cache::isMemoized('count'))->toBeFalse();

    expect(Cache::get('count'))->toBe(0);

    expect(Cache::isMemoized('count'))->toBeTrue();
});

it('forgets when forever', function () {
    Cache::put('key', 'value-1', 60);

    expect(Cache::isMemoized('key'))->toBeFalse();

    expect(Cache::get('key'))->toBe('value-1');

    expect(Cache::isMemoized('key'))->toBeTrue();

    Cache::forever('key', 'value-2');

    expect(Cache::isMemoized('key'))->toBeFalse();

    expect(Cache::get('key'))->toBe('value-2');

    expect(Cache::isMemoized('key'))->toBeTrue();
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

it('resets with scoped instances', function () {

})->todo();

it('throws when store does not support locks', function () {

})->todo();

it('supports flexible', function () {
    $this->freezeTime();

    Cache::flexible('key', [10, 20], 'value-1');

    $this->travel(11)->seconds();

    Cache::flexible('key', [10, 20], 'value-2');

    defer()->invoke();

    expect(Cache::get('key'))->toBe('value-2');
})->todo();