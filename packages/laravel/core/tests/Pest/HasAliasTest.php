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
        ->hasAlias()->toBeFalse();
});

it('sets', function () {
    expect($this->test->alias('test'))
        ->toBeInstanceOf(AliasTest::class)
        ->hasAlias()->toBeTrue();
});

it('gets', function () {
    expect($this->test->alias('test'))
        ->getAlias()->toBe('test')
        ->hasAlias()->toBeTrue();
});
