<?php

declare(strict_types=1);

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Bar;

beforeEach(function () {
    $this->series = Bar::make();
});

it('is bar type', function () {
    expect($this->series)
        ->getType()->toBe(ChartType::Bar);
});