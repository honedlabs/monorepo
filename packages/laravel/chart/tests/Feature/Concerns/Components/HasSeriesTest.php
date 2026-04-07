<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Bar;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can have series', function () {
    $bar = Bar::make();

    expect($this->chart)
        ->hasSeries()->toBeFalse()
        ->series($bar)->toBe($this->chart)
        ->hasSeries()->toBeTrue()
        ->hasSeries(ChartType::Bar)->toBeTrue()
        ->hasSeries(ChartType::Line)->toBeFalse()
        ->getSeries()->count()->toBe(1)
        ->series([Bar::make(), Bar::make()])
        ->getSeries()->count()->toBe(3);
});
