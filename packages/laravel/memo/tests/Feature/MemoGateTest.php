<?php

declare(strict_types=1);

use App\Models\User;
use Honed\Memo\MemoGate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('binds', function () {
    expect(Gate::getFacadeRoot())->toBeInstanceOf(MemoGate::class);
});

it('memoizes gate checks', function () {
    // The 'even' gate calls Response::denyAsNotFound() but doesn't return it
    // So it returns null, which Gate::allows() converts to false
    expect(Gate::allows('even'))->toBeFalse();
    expect(Gate::allows('even'))->toBeFalse();
    expect(fn () => Gate::authorize('even'))->toThrow(AuthorizationException::class);

    // Test that the raw method also returns null for the 'even' gate
    $gate = Gate::getFacadeRoot();
    $result = $gate->raw('even');
    expect($result)->toBeNull();
});

it('memoizes raw gate results', function () {
    $gate = Gate::getFacadeRoot();

    // First call should execute the gate callback
    $result1 = $gate->raw('odd');
    expect($result1)->toBeTrue();

    // Second call should return memoized result
    $result2 = $gate->raw('odd');
    expect($result2)->toBeTrue();

    // Verify it's actually memoized by checking the hash exists
    $hash = $gate->getHash('odd', []);
    expect($gate->isMemoized($hash))->toBeTrue();
});

it('memoizes raw gate results with arguments', function () {
    $gate = Gate::getFacadeRoot();

    // Define a gate that accepts additional arguments
    Gate::define('with-args', function (User $user, $arg1, $arg2) {
        return $user->getKey() % 2 === 1 && $arg1 === 'test' && $arg2 === 'data';
    });

    // Test with positional arguments
    $result1 = $gate->raw('with-args', ['test', 'data']);
    expect($result1)->toBeTrue();

    $result2 = $gate->raw('with-args', ['test', 'data']);
    expect($result2)->toBeTrue();

    // Different arguments should create different hash
    $result3 = $gate->raw('with-args', ['different', 'data']);
    expect($result3)->toBeFalse();

    $hash1 = $gate->getHash('with-args', ['test', 'data']);
    $hash2 = $gate->getHash('with-args', ['different', 'data']);
    expect($hash1)->not->toBe($hash2);
    expect($gate->isMemoized($hash1))->toBeTrue();
    expect($gate->isMemoized($hash2))->toBeTrue();
});

it('handles null values in memoization', function () {
    $gate = Gate::getFacadeRoot();

    // Create a gate that returns null
    Gate::define('nullable', function () {
        return null;
    });

    $result1 = $gate->raw('nullable');
    expect($result1)->toBeNull();

    $result2 = $gate->raw('nullable');
    expect($result2)->toBeNull();

    $hash = $gate->getHash('nullable', []);
    expect($gate->isMemoized($hash))->toBeTrue();
});

it('memoizes forUser gate instances', function () {
    $gate = Gate::getFacadeRoot();
    $user1 = User::factory()->create(['id' => 100]);
    $user2 = User::factory()->create(['id' => 200]);

    // First call should create and memoize gate instance
    $gateForUser1_1 = $gate->forUser($user1);
    expect($gateForUser1_1)->toBeInstanceOf(MemoGate::class);

    // Second call should return memoized instance
    $gateForUser1_2 = $gate->forUser($user1);
    expect($gateForUser1_2)->toBe($gateForUser1_1);

    // Different user should create different instance
    $gateForUser2 = $gate->forUser($user2);
    expect($gateForUser2)->toBeInstanceOf(MemoGate::class);
    expect($gateForUser2)->not->toBe($gateForUser1_1);

    // Verify memoization keys
    expect($gate->isMemoized((string) $user1->getAuthIdentifier()))->toBeTrue();
    expect($gate->isMemoized((string) $user2->getAuthIdentifier()))->toBeTrue();
});

it('handles different user auth identifier types', function () {
    $gate = Gate::getFacadeRoot();

    // Test with different users (avoid ID conflicts)
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $gateForUser1 = $gate->forUser($user1);
    expect($gateForUser1)->toBeInstanceOf(MemoGate::class);
    expect($gate->isMemoized((string) $user1->getAuthIdentifier()))->toBeTrue();

    $gateForUser2 = $gate->forUser($user2);
    expect($gateForUser2)->toBeInstanceOf(MemoGate::class);
    expect($gate->isMemoized((string) $user2->getAuthIdentifier()))->toBeTrue();

    // Verify they have different identifiers
    expect($user1->getAuthIdentifier())->not->toBe($user2->getAuthIdentifier());
});

it('generates consistent hashes for same inputs', function () {
    $gate = Gate::getFacadeRoot();

    $hash1 = $gate->getHash('test', ['param1', 'param2']);
    $hash2 = $gate->getHash('test', ['param1', 'param2']);
    expect($hash1)->toBe($hash2);

    // Different order should produce different hash
    $hash3 = $gate->getHash('test', ['param2', 'param1']);
    expect($hash1)->not->toBe($hash3);
});

it('handles complex argument types in hash generation', function () {
    $gate = Gate::getFacadeRoot();

    $complexArgs = [
        'string' => 'value',
        'number' => 123,
        'array' => ['nested' => 'data'],
        'object' => (object) ['prop' => 'value'],
        'null' => null,
        'boolean' => true,
    ];

    $hash1 = $gate->getHash('complex', $complexArgs);
    $hash2 = $gate->getHash('complex', $complexArgs);
    expect($hash1)->toBe($hash2);

    // Verify hash is a valid MD5
    expect($hash1)->toMatch('/^[a-f0-9]{32}$/');
});

it('clears memoized values', function () {
    $gate = Gate::getFacadeRoot();

    // Memoize some values
    $gate->raw('odd');
    $user = User::factory()->create();
    $gate->forUser($user);

    $hash = $gate->getHash('odd', []);
    $userKey = (string) $user->getAuthIdentifier();

    expect($gate->isMemoized($hash))->toBeTrue();
    expect($gate->isMemoized($userKey))->toBeTrue();

    // Clear all memoized values
    $gate->clearMemoized();

    expect($gate->isMemoized($hash))->toBeFalse();
    expect($gate->isMemoized($userKey))->toBeFalse();
});

it('handles authorization denials in memoization', function () {
    $gate = Gate::getFacadeRoot();

    // Create a gate that properly returns a denial response
    Gate::define('deny-test', function (User $user) {
        return Response::deny('Access denied for testing');
    });

    // The gate should return a denial response that gets memoized
    $result1 = $gate->raw('deny-test');
    $result2 = $gate->raw('deny-test');

    // Both should return the same denial response
    expect($result1)->toBeInstanceOf(Response::class);
    expect($result2)->toBeInstanceOf(Response::class);
    expect($result1->denied())->toBeTrue();
    expect($result2->denied())->toBeTrue();

    // Verify the result is memoized
    $hash = $gate->getHash('deny-test', []);
    expect($gate->isMemoized($hash))->toBeTrue();
});

it('memoizes different gate abilities separately', function () {
    $gate = Gate::getFacadeRoot();

    // Define a gate that returns false
    Gate::define('always-false', function (User $user) {
        return false;
    });

    $result1 = $gate->raw('odd');
    expect($result1)->toBeTrue();

    $result2 = $gate->raw('always-false');
    expect($result2)->toBeFalse();

    // Verify both are memoized with different hashes
    $oddHash = $gate->getHash('odd', []);
    $falseHash = $gate->getHash('always-false', []);

    expect($oddHash)->not->toBe($falseHash);
    expect($gate->isMemoized($oddHash))->toBeTrue();
    expect($gate->isMemoized($falseHash))->toBeTrue();
});

it('preserves gate context in forUser instances', function () {
    $gate = Gate::getFacadeRoot();
    $user = User::factory()->create(['id' => 2]); // Even ID

    $userGate = $gate->forUser($user);

    // The user gate should work with the specific user context
    expect($userGate->allows('even'))->toBeTrue();
    expect($userGate->allows('odd'))->toBeFalse();
});

it('handles unmemoize functionality', function () {
    $gate = Gate::getFacadeRoot();

    $gate->raw('odd');
    $hash = $gate->getHash('odd', []);

    expect($gate->isMemoized($hash))->toBeTrue();

    $gate->unmemoize($hash);

    expect($gate->isMemoized($hash))->toBeFalse();
});

it('handles edge case with empty arguments', function () {
    $gate = Gate::getFacadeRoot();

    $result1 = $gate->raw('odd', []);
    $result2 = $gate->raw('odd', null);
    $result3 = $gate->raw('odd');

    expect($result1)->toBeTrue();
    expect($result2)->toBeTrue();
    expect($result3)->toBeTrue();

    // All should be memoized but with potentially different hashes
    $hash1 = $gate->getHash('odd', []);
    $hash2 = $gate->getHash('odd', null);
    $hash3 = $gate->getHash('odd', []);

    expect($gate->isMemoized($hash1))->toBeTrue();
    expect($gate->isMemoized($hash2))->toBeTrue();
    expect($hash1)->toBe($hash3); // [] and default should be same
});

it('handles concurrent memoization correctly', function () {
    $gate = Gate::getFacadeRoot();

    // Simulate concurrent access patterns
    $results = [];
    for ($i = 0; $i < 10; $i++) {
        $results[] = $gate->raw('odd');
    }

    // All results should be the same
    foreach ($results as $result) {
        expect($result)->toBeTrue();
    }

    // Should only be memoized once
    $hash = $gate->getHash('odd', []);
    expect($gate->isMemoized($hash))->toBeTrue();
});

it('handles memory pressure with many memoized values', function () {
    $gate = Gate::getFacadeRoot();

    // Create many different gate checks to test memory handling
    for ($i = 0; $i < 100; $i++) {
        Gate::define("test_gate_{$i}", function () use ($i) {
            return $i % 2 === 0;
        });

        $result = $gate->raw("test_gate_{$i}");
        expect($result)->toBe($i % 2 === 0);
    }

    // Verify all are memoized
    for ($i = 0; $i < 100; $i++) {
        $hash = $gate->getHash("test_gate_{$i}", []);
        expect($gate->isMemoized($hash))->toBeTrue();
    }
});

it('handles forUser with users having null auth identifiers', function () {
    $gate = Gate::getFacadeRoot();

    // Create a mock user with null identifier
    $user = new class()
    {
        public function getAuthIdentifier()
        {
            return null;
        }
    };

    $userGate = $gate->forUser($user);
    expect($userGate)->toBeInstanceOf(MemoGate::class);

    // Should be memoized with empty string key
    expect($gate->isMemoized(''))->toBeTrue();
});

it('handles forUser with users having zero auth identifiers', function () {
    $gate = Gate::getFacadeRoot();

    // Create a mock user with zero identifier
    $user = new class()
    {
        public function getAuthIdentifier()
        {
            return 0;
        }
    };

    $userGate = $gate->forUser($user);
    expect($userGate)->toBeInstanceOf(MemoGate::class);

    // Should be memoized with '0' key
    expect($gate->isMemoized('0'))->toBeTrue();
});

it('handles very large argument arrays', function () {
    $gate = Gate::getFacadeRoot();

    // Define a gate that accepts many arguments
    Gate::define('large-args', function (User $user, ...$args) {
        return $user->getKey() % 2 === 1 && count($args) === 1000;
    });

    // Create a large argument array
    $largeArgs = array_fill(0, 1000, 'test_value');

    $result1 = $gate->raw('large-args', $largeArgs);
    $result2 = $gate->raw('large-args', $largeArgs);

    expect($result1)->toBeTrue();
    expect($result2)->toBeTrue();

    $hash = $gate->getHash('large-args', $largeArgs);
    expect($gate->isMemoized($hash))->toBeTrue();
});

it('handles deeply nested argument structures', function () {
    $gate = Gate::getFacadeRoot();

    // Define a gate that accepts nested arguments
    Gate::define('nested-args', function (User $user, $nestedData) {
        return $user->getKey() % 2 === 1 &&
               isset($nestedData['level1']['level2']['level3']['level4']) &&
               $nestedData['level1']['level2']['level3']['level4'] === 'deep_value';
    });

    // Create deeply nested structure
    $deepArgs = [['level1' => ['level2' => ['level3' => ['level4' => 'deep_value']]]]];

    $result1 = $gate->raw('nested-args', $deepArgs);
    $result2 = $gate->raw('nested-args', $deepArgs);

    expect($result1)->toBeTrue();
    expect($result2)->toBeTrue();

    $hash = $gate->getHash('nested-args', $deepArgs);
    expect($gate->isMemoized($hash))->toBeTrue();
});

it('handles special characters in gate names', function () {
    $gate = Gate::getFacadeRoot();

    $specialGates = [
        'gate-with-dashes',
        'gate_with_underscores',
        'gate.with.dots',
        'gate with spaces',
        'gate@with#special$chars%',
    ];

    foreach ($specialGates as $gateName) {
        Gate::define($gateName, function () {
            return true;
        });

        $result = $gate->raw($gateName);
        expect($result)->toBeTrue();

        $hash = $gate->getHash($gateName, []);
        expect($gate->isMemoized($hash))->toBeTrue();
    }
});

it('handles unicode characters in arguments', function () {
    $gate = Gate::getFacadeRoot();

    // Define a gate that accepts unicode arguments
    Gate::define('unicode-args', function (User $user, $unicodeData) {
        return $user->getKey() % 2 === 1 &&
               isset($unicodeData['emoji']) &&
               $unicodeData['emoji'] === '🚀🎉🔥';
    });

    $unicodeArgs = [[
        'emoji' => '🚀🎉🔥',
        'chinese' => '你好世界',
        'arabic' => 'مرحبا بالعالم',
        'russian' => 'Привет мир',
    ]];

    $result1 = $gate->raw('unicode-args', $unicodeArgs);
    $result2 = $gate->raw('unicode-args', $unicodeArgs);

    expect($result1)->toBeTrue();
    expect($result2)->toBeTrue();

    $hash = $gate->getHash('unicode-args', $unicodeArgs);
    expect($gate->isMemoized($hash))->toBeTrue();
});

it('maintains memoization across different gate method calls', function () {
    $gate = Gate::getFacadeRoot();

    // Call raw method first
    $rawResult = $gate->raw('odd');
    expect($rawResult)->toBeTrue();

    // Then call allows method - should use same memoized result
    $allowsResult = $gate->allows('odd');
    expect($allowsResult)->toBeTrue();

    // Verify memoization
    $hash = $gate->getHash('odd', []);
    expect($gate->isMemoized($hash))->toBeTrue();
});

it('handles circular reference in arguments gracefully', function () {
    $gate = Gate::getFacadeRoot();

    // Create circular reference
    $obj1 = new stdClass();
    $obj2 = new stdClass();
    $obj1->ref = $obj2;
    $obj2->ref = $obj1;

    // This should throw a JsonException due to circular reference in hash generation
    expect(function () use ($gate, $obj1) {
        $gate->getHash('test', [$obj1]);
    })->toThrow(JsonException::class);

    // But we can test that simple objects work fine
    $simpleObj = new stdClass();
    $simpleObj->prop = 'value';

    $hash = $gate->getHash('test', [$simpleObj]);
    expect($hash)->toBeString();
    expect($hash)->toMatch('/^[a-f0-9]{32}$/');
});

it('verifies memoization performance benefit', function () {
    $gate = Gate::getFacadeRoot();

    // Define a gate that simulates expensive operation
    Gate::define('expensive', function () {
        usleep(1000); // 1ms delay

        return true;
    });

    // First call (should be slower)
    $start1 = microtime(true);
    $result1 = $gate->raw('expensive');
    $time1 = microtime(true) - $start1;

    // Second call (should be faster due to memoization)
    $start2 = microtime(true);
    $result2 = $gate->raw('expensive');
    $time2 = microtime(true) - $start2;

    expect($result1)->toBeTrue();
    expect($result2)->toBeTrue();

    // Second call should be significantly faster
    expect($time2)->toBeLessThan($time1 * 0.5);
});
