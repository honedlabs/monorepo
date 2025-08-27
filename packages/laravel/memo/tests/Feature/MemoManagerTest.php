<?php

declare(strict_types=1);

use Honed\Memo\Facades\Memo;
use Honed\Memo\MemoManager;

beforeEach(function () {
    $this->instance = app('memo');
});

it('gets', function () {
    expect($this->instance)
        ->get('test')->toBeNull()
        ->put('test', 'value')->toBe('value')
        ->get('test')->toBe('value');
});

it('puts', function () {
    expect($this->instance)
        ->put('test', 'value')->toBe('value')
        ->isMemoized('test')->toBeTrue()
        ->put('test', null)->toBeNull()
        ->isMemoized('test')->toBeTrue();
});

it('pulls', function () {
    expect($this->instance)
        ->put('test', 'value')->toBe('value')
        ->isMemoized('test')->toBeTrue()
        ->pull('test')->toBe('value')
        ->isMemoized('test')->toBeFalse();
});

it('forgets', function () {
    expect($this->instance)
        ->put('test', 'value')->toBe('value')
        ->isMemoized('test')->toBeTrue()
        ->forget('test')->toBeNull()
        ->isNotMemoized('test')->toBeTrue();
});

it('clears', function () {
    expect($this->instance)
        ->put('test', 'value')->toBe('value')
        ->isMemoized('test')->toBeTrue()
        ->clear()->toBeNull()
        ->isNotMemoized('test')->toBeTrue();
});