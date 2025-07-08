<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasOrder;

beforeEach(function () {
    $this->test = new class()
    {
        use HasOrder;
    };
});

it('sets the order', function () {
    expect($this->test)
        ->getOrder()->toBe(0)
        ->order(10)->toBe($this->test)
        ->getOrder()->toBe(10)
        ->orderFirst()->toBe($this->test)
        ->getOrder()->toBe(-1)
        ->orderLast()->toBe($this->test)
        ->getOrder()->toBe(PHP_INT_MAX)
        ->orderDefault()->toBe($this->test)
        ->getOrder()->toBe(0);
});
