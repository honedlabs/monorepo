<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasAlias;

class AliasTest
{
    use HasAlias;
}

beforeEach(function () {
    $this->test = new AliasTest;
});

it('is null by default', function () {
    expect($this->test)
        ->alias()->toBeNull()
        ->hasAlias()->toBeFalse();
});

it('sets', function () {
    expect($this->test->alias('test'))
        ->toBeInstanceOf(AliasTest::class)
        ->alias()->toBe('test')
        ->hasAlias()->toBeTrue();
});

it('gets', function () {
    expect($this->test->alias('test'))
        ->alias()->toBe('test')
        ->hasAlias()->toBeTrue();
});