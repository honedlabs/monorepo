<?php

declare(strict_types=1);

use Honed\Chart\Axis;
use Honed\Chart\Enums\AxisType;
use Honed\Chart\Enums\Dimension;

beforeEach(function () {
    $this->axis = Axis::make();
});

it('has type', function () {
    expect($this->axis)
        ->getType()->toBeNull()
        // ->value()->toBe($this->axis)
        // ->getType()->toBe(AxisType::Value)
        // ->category()->toBe($this->axis)
        // ->getType()->toBe(AxisType::Category)
        ->time()->toBe($this->axis)
        ->getType()->toBe(AxisType::Time)
        ->log()->toBe($this->axis)
        ->getType()->toBe(AxisType::Log)
        ->type('value')->toBe($this->axis)
        ->getType()->toBe(AxisType::Value);
});

it('has dimension', function () {
    expect($this->axis)
        ->x()->toBe($this->axis)
        ->getDimension()->toBe(Dimension::X)
        ->y()->toBe($this->axis)
        ->getDimension()->toBe(Dimension::Y)
        ->dimension('x')->toBe($this->axis)
        ->getDimension()->toBe(Dimension::X);
});
