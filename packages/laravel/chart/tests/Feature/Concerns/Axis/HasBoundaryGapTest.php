<?php

declare(strict_types=1);

use Honed\Chart\Axis;

beforeEach(function () {
    $this->axis = Axis::make();
});

it('has boundary gap', function () {
    expect($this->axis)
        ->getBoundaryGap()->toBeNull()
        ->boundaryGap(false)->toBe($this->axis)
        ->getBoundaryGap()->toBeFalse()
        ->boundaryGap(true)->toBe($this->axis)
        ->getBoundaryGap()->toBeTrue()
        ->boundaryGap([0, 0.01])->toBe($this->axis)
        ->getBoundaryGap()->toEqual([0, 0.01]);
});
