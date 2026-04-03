<?php

declare(strict_types=1);

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Line;

beforeEach(function () {
    $this->series = Line::make();
});

it('is line type', function () {
    expect($this->series)
        ->getType()->toBe(ChartType::Line);
});