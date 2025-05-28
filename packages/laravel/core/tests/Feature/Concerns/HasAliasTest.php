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
        ->hasAlias()->toBeFalse()
        ->getAlias()->toBeNull()
        ->alias('test')->toBe($this->test)
        ->getAlias()->toBe('test')
        ->hasAlias()->toBeTrue();
});
