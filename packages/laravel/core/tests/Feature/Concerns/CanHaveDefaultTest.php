<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanHaveDefault;

beforeEach(function () {
    $this->test = new class()
    {
        use CanHaveDefault;
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
