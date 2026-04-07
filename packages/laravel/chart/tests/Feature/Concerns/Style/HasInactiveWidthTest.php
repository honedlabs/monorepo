<?php

declare(strict_types=1);

use Honed\Chart\Legend;

beforeEach(function () {
    $this->legend = Legend::make();
});

it('has inactive width', function () {
    expect($this->legend)
        ->getInactiveWidth()->toBeNull()
        ->inactiveWidth(0)->toBe($this->legend)
        ->getInactiveWidth()->toBe(0);
});
