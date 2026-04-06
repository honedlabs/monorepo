<?php

declare(strict_types=1);

use Honed\Chart\AxisX;
use Honed\Chart\Enums\Dimension;

beforeEach(function () {
    $this->axis = AxisX::make();
});

it('has x dimension', function () {
    expect($this->axis)
        ->getDimension()->toBe(Dimension::X);
});
