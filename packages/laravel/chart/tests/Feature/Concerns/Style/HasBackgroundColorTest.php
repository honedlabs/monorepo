<?php

declare(strict_types=1);

use Honed\Chart\Tooltip;

beforeEach(function () {
    $this->tooltip = Tooltip::make();
});

it('has background color', function () {
    expect($this->tooltip)
        ->getBackgroundColor()->toBeNull()
        ->backgroundColor('#f5f5f5')->toBe($this->tooltip)
        ->getBackgroundColor()->toBe('#f5f5f5');
});
