<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasAlias;

beforeEach(function () {
    $this->test = new class()
    {
        use HasAlias;
    };
});

it('sets', function () {
    expect($this->test)
        ->getAlias()->toBeNull()
        ->hasAlias()->toBeFalse()
        ->alias('test')->toBe($this->test)
        ->getAlias()->toBe('test')
        ->hasAlias()->toBeTrue()
        ->dontAlias()->toBe($this->test)
        ->getAlias()->toBeNull()
        ->hasAlias()->toBeFalse();
});
