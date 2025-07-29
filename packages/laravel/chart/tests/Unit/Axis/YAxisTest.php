<?php

declare(strict_types=1);

use Honed\Chart\Axis\Axis;
use Honed\Chart\Axis\YAxis;

it('has y dimension', function () {
    expect(YAxis::make())
        ->getDimension()->toBe(Axis::Y);
});