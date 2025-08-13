<?php

declare(strict_types=1);

use Honed\Chart\Axis\Axis;
use Honed\Chart\Axis\XAxis;

it('has x dimension', function () {
    expect(XAxis::make())
        ->getDimension()->toBe(Axis::X);
});
