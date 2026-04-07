<?php

declare(strict_types=1);

use Honed\Chart\Series\Line;

beforeEach(function () {
    $this->series = Line::make();
});

it('has stack', function () {
    expect($this->series)
        ->getStack()->toBeNull()
        ->stack('total')->toBe($this->series)
        ->getStack()->toBe('total')
        ->stack(null)->toBe($this->series)
        ->getStack()->toBeNull();
});
