<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasTarget;

beforeEach(function () {
    $this->test = new class()
    {
        use Evaluable;
        use HasTarget;
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
