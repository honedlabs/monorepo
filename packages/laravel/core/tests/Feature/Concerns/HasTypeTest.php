<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasType;

beforeEach(function () {
    $this->test = new class()
    {
        use HasType;
    };
});

it('sets', function () {
    expect($this->test)
        ->getType()->toBeNull()
        ->type('test')->toBe($this->test)
        ->getType()->toBe('test');
});
