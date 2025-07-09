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
        ->getOrder()->toBe($this->test::ORDER_DEFAULT)
        ->order(5)->toBe($this->test)
        ->getOrder()->toBe(5)
        ->orderBefore()->toBe($this->test)
        ->getOrder()->toBe($this->test::ORDER_BEFORE)
        ->orderStart()->toBe($this->test)
        ->getOrder()->toBe($this->test::ORDER_START)
        ->orderDefault()->toBe($this->test)
        ->getOrder()->toBe($this->test::ORDER_DEFAULT)
        ->orderEnd()->toBe($this->test)
        ->getOrder()->toBe($this->test::ORDER_END)
        ->orderAfter()->toBe($this->test)
        ->getOrder()->toBe($this->test::ORDER_LAST);
});
