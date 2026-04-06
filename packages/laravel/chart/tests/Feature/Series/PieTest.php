<?php

declare(strict_types=1);

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Pie;

beforeEach(function () {
    $this->series = Pie::make();
});

it('is pie type', function () {
    expect($this->series)
        ->getType()->toBe(ChartType::Pie);
});
