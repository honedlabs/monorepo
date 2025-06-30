<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanHaveTarget;

beforeEach(function () {
    $this->test = new class()
    {
        use CanHaveTarget;
    };
});

it('sets target', function () {
    expect($this->test)
        ->getTarget()->toBeNull()
        ->target('_self')->toBe($this->test)
        ->getTarget()->toBe('_self')
        ->openUrlInNewTab()->toBe($this->test)
        ->getTarget()->toBe('_blank');
});
