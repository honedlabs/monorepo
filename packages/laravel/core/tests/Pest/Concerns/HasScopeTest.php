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
        ->hasScope()->toBeFalse();
});

it('sets', function () {
    expect($this->test->scope('test'))
        ->toBeInstanceOf(ScopeTest::class)
        ->hasScope()->toBeTrue();
});

it('gets', function () {
    expect($this->test->scope('test'))
        ->getScope()->toBe('test')
        ->hasScope()->toBeTrue();
});
