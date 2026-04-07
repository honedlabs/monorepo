<?php

declare(strict_types=1);

use Honed\Chart\Legend;

beforeEach(function () {
    $this->legend = Legend::make();
});

it('has inactive color', function () {
    expect($this->legend)
        ->getInactiveColor()->toBeNull()
        ->inactiveColor('#999')->toBe($this->legend)
        ->getInactiveColor()->toBe('#999');
});
