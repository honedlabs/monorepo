<?php

declare(strict_types=1);

use Honed\Chart\Axis;
use Honed\Chart\Chart;
use Honed\Chart\Enums\Dimension;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can have axes', function () {
    expect($this->chart)
        ->hasAxes()->toBeFalse()
        ->x()->hasAxes(Dimension::X)->toBeTrue()
        ->hasAxes(Dimension::Y)->toBeFalse()
        ->getAxes(Dimension::X)->count()->toBe(1)
        ->y()->hasAxes(Dimension::Y)->toBeTrue()
        ->getAxes()->count()->toBe(2);
});

it('can merge axis from enumerable', function () {
    $this->chart->axes(collect([
        Axis::make()->dimension(Dimension::Y),
    ]));

    expect($this->chart->getAxes(Dimension::Y)->count())->toBeGreaterThan(0);
});
