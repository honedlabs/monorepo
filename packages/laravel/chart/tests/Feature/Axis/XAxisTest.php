<?php

declare(strict_types=1);

use Honed\Chart\Axis\XAxis;
use Honed\Chart\Enums\Dimension;

beforeEach(function () {
    $this->axis = XAxis::make();
});

it('has x dimension', function () {
    expect($this->axis)
        ->getDimension()->toBe(Dimension::X);
});
