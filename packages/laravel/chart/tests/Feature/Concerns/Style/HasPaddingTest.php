<?php

declare(strict_types=1);

use Honed\Chart\Legend;

beforeEach(function () {
    $this->legend = Legend::make();
});

it('has padding', function () {
    expect($this->legend)
        ->getPadding()->toBeNull()
        ->padding([8, 12])->toBe($this->legend)
        ->getPadding()->toEqual([8, 12]);
});
