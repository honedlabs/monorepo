<?php

declare(strict_types=1);

use Honed\Chart\AxisY;
use Honed\Chart\Enums\Dimension;

beforeEach(function () {
    $this->axis = AxisY::make();
});

it('has y dimension', function () {
    expect($this->axis)
        ->getDimension()->toBe(Dimension::Y);
});
