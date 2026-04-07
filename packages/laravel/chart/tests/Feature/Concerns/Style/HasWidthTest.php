<?php

declare(strict_types=1);

use Honed\Chart\Legend;

beforeEach(function () {
    $this->legend = Legend::make();
});

it('has width', function () {
    expect($this->legend)
        ->getWidth()->toBeNull()
        ->width('auto')->toBe($this->legend)
        ->getWidth()->toBe('auto');
});
