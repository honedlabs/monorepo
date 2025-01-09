<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasScope;

class ScopeTest
{
    use HasScope;
}

beforeEach(function () {
    $this->test = new ScopeTest;
});

it('is null by default', function () {
    expect($this->test)
        ->scope()->toBeNull()
        ->hasScope()->toBeFalse();
});

it('sets', function () {
    expect($this->test->scope('test'))
        ->toBeInstanceOf(ScopeTest::class)
        ->scope()->toBe('test')
        ->hasScope()->toBeTrue();
});

it('gets', function () {
    expect($this->test->scope('test'))
        ->scope()->toBe('test')
        ->hasScope()->toBeTrue();
});