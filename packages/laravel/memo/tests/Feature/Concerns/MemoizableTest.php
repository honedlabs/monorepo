<?php

declare(strict_types=1);

use App\Models\User;
use Honed\Memo\MemoManager;

beforeEach(function () {
    $this->instance = new MemoManager();
});

it('memoizes', function () {
    expect($this->instance)
        ->memoized('test')->toBeNull()
        ->isNotMemoized('test')->toBeTrue()
        ->memoize('test', 'value')->toBe('value')
        ->isMemoized('test')->toBeTrue()
        ->memoized('test')->toBe('value')
        ->unmemoize('test')->toBeNull()
        ->isNotMemoized('test')->toBeTrue()
        ->memoize('test', 'value')->toBe('value')
        ->isMemoized('test')->toBeTrue()
        ->clearMemoized()->toBeNull()
        ->isNotMemoized('test')->toBeTrue();
});

it('hashes', function () {
    expect($this->instance)
        ->getHash('string')->toBe(hash('md5', json_encode(['string'])))
        ->getHash($user = User::factory()->create())->toBe(hash('md5', json_encode([$user])));
});
