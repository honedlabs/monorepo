<?php

declare(strict_types=1);

use Honed\Chart\Legend;

beforeEach(function () {
    $this->legend = Legend::make();
});

it('has inactive border color', function () {
    expect($this->legend)
        ->getInactiveBorderColor()->toBeNull()
        ->inactiveBorderColor('#ccc')->toBe($this->legend)
        ->getInactiveBorderColor()->toBe('#ccc');
});
