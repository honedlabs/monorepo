<?php

declare(strict_types=1);

use Honed\Chart\Axis\YAxis;
use Honed\Chart\Enums\Dimension;

beforeEach(function () {
    $this->axis = YAxis::make();
});

it('has y dimension', function () {
    expect($this->axis)
        ->getDimension()->toBe(Dimension::Y);
});
