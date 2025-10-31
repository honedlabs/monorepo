<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasDefault;

beforeEach(function () {
    $this->test = new class()
    {
        use HasDefault;
    };
});

it('sets', function () {
    expect($this->test)
        ->getDefault()->toBeNull()
        ->hasDefault()->toBeFalse()
        ->default('default')->toBe($this->test)
        ->getDefault()->toBe('default')
        ->hasDefault()->toBeTrue();
});
