<?php

declare(strict_types=1);

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Doughnut;

beforeEach(function () {
    $this->series = Doughnut::make();
});

it('is doughnut type', function () {
    expect($this->series)
        ->getType()->toBe(ChartType::Pie);
});