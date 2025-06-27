<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanHaveIcon;
use Honed\Core\Concerns\Evaluable;

beforeEach(function () {
    $this->test = new class()
    {
        use CanHaveIcon, Evaluable;
    };
});

it('sets', function () {
    expect($this->test)
        ->getIcon()->toBeNull()
        ->hasIcon()->toBeFalse()
        ->icon('icon')->toBe($this->test)
        ->getIcon()->toBe('icon')
        ->hasIcon()->toBeTrue();
});
