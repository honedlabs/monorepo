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
    config()->set('cache.stores.memo.store', 'redis');

    expect(app('cache'))
        ->getPrefix()->toBe('laravel_cache_');

    app('cache')->driver('redis')->setPrefix('foo');

    expect(app('cache')->getPrefix())->toBe('foo');
});

it('dispatches events', function () {})->skip();

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
        ->get('key')->toBe('value-2')
        ->isMemoized('key')->toBeTrue();
});

it('handles putMany with memoization', function () {
    expect(app('cache'))
        ->putMany(['key-1' => 'value-1', 'key-2' => 'value-2'], 60)->toBeTrue()
        ->get('key-1')->toBe('value-1')
        ->get('key-2')->toBe('value-2')
        ->isMemoized('key-1')->toBeTrue()
        ->isMemoized('key-2')->toBeTrue()
        ->putMany(['key-1' => 'new-value-1', 'key-2' => 'new-value-2'], 60)->toBeTrue()
        ->isMemoized('key-1')->toBeFalse()
        ->isMemoized('key-2')->toBeFalse()
        ->get('key-1')->toBe('new-value-1')
        ->get('key-2')->toBe('new-value-2');
});

it('handles many with mixed memoized and non-memoized keys', function () {
    $cache = app('cache');
    
    expect($cache)
        ->put('key-1', 'value-1', 60)->toBeTrue()
        ->get('key-1')->toBe('value-1')
        ->isMemoized('key-1')->toBeTrue()
        ->put('key-2', 'value-2', 60)->toBeTrue();
        
    $result = $cache->many(['key-1', 'key-2', 'key-3']);
    
    expect($result)->toEqualCanonicalizing([
        'key-1' => 'value-1',
        'key-2' => 'value-2',
        'key-3' => null,
    ]);
    
    expect($cache)
        ->isMemoized('key-1')->toBeTrue()
        ->isMemoized('key-2')->toBeTrue()
        ->isMemoized('key-3')->toBeFalse();
});


it('handles many with all memoized keys', function () {
    expect(app('cache'))
        ->put('key-1', 'value-1', 60)->toBeTrue()
        ->put('key-2', 'value-2', 60)->toBeTrue()
        ->get('key-1')->toBe('value-1')
        ->get('key-2')->toBe('value-2')
        ->isMemoized('key-1')->toBeTrue()
        ->isMemoized('key-2')->toBeTrue()
        ->many(['key-1', 'key-2'])->toEqualCanonicalizing([
            'key-1' => 'value-1',
            'key-2' => 'value-2',
        ])
        ->isMemoized('key-1')->toBeTrue()
        ->isMemoized('key-2')->toBeTrue();
});

it('handles many with empty array', function () {
    expect(app('cache'))
        ->many([])->toEqualCanonicalizing([]);
});

it('handles many with duplicate keys', function () {
    expect(app('cache'))
        ->put('key-1', 'value-1', 60)->toBeTrue()
        ->many(['key-1', 'key-1', 'key-2'])->toEqualCanonicalizing([
            'key-1' => 'value-1',
            'key-2' => null,
        ]);
});

it('handles increment with custom value', function () {
    expect(app('cache'))
        ->put('count', 10, 60)->toBeTrue()
        ->get('count')->toBe(10)
        ->isMemoized('count')->toBeTrue()
        ->increment('count', 5)->toBe(15)
        ->isMemoized('count')->toBeFalse()
        ->get('count')->toBe(15);
});

it('handles decrement with custom value', function () {
    expect(app('cache'))
        ->put('count', 10, 60)->toBeTrue()
        ->get('count')->toBe(10)
        ->isMemoized('count')->toBeTrue()
        ->decrement('count', 3)->toBe(7)
        ->isMemoized('count')->toBeFalse()
        ->get('count')->toBe(7);
});

it('handles repository method access', function () {
    $cache = app('cache');
    
    expect($cache->getRepository())->toBeInstanceOf(\Illuminate\Cache\Repository::class);
});

it('handles prefix operations', function () {
    $cache = app('cache');
    
    expect($cache->getPrefix())->toBeString();
    
    $originalPrefix = $cache->getPrefix();
    
    expect($originalPrefix)->toBeString();
});

it('handles complex memoization scenarios', function () {
    expect(app('cache'))
        ->put('key-1', ['nested' => ['data' => 'value']], 60)->toBeTrue()
        ->get('key-1')->toEqualCanonicalizing(['nested' => ['data' => 'value']])
        ->isMemoized('key-1')->toBeTrue()
        ->put('key-1', (object) ['prop' => 'object-value'], 60)->toBeTrue()
        ->isMemoized('key-1')->toBeFalse()
        ->get('key-1')->toEqual((object) ['prop' => 'object-value'])
        ->isMemoized('key-1')->toBeTrue();
});

it('handles large data memoization', function () {
    $largeData = array_fill(0, 1000, 'large-value');
    
    expect(app('cache'))
        ->put('large-key', $largeData, 60)->toBeTrue()
        ->get('large-key')->toEqualCanonicalizing($largeData)
        ->isMemoized('large-key')->toBeTrue()
        ->get('large-key')->toEqualCanonicalizing($largeData)
        ->isMemoized('large-key')->toBeTrue();
});

it('handles unicode data memoization', function () {
    $unicodeData = [
        'emoji' => '🚀🎉🔥',
        'chinese' => '你好世界',
        'arabic' => 'مرحبا بالعالم',
    ];
    
    expect(app('cache'))
        ->put('unicode-key', $unicodeData, 60)->toBeTrue()
        ->get('unicode-key')->toEqualCanonicalizing($unicodeData)
        ->isMemoized('unicode-key')->toBeTrue();
});
