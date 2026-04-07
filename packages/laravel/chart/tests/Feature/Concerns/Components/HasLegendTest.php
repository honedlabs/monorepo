<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Legend;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can have legend', function () {
    expect($this->chart)
        ->getLegend()->toBeNull()
        ->legend()->toBe($this->chart)
        ->getLegend()->toBeInstanceOf(Legend::class)
        ->legend(false)->toBe($this->chart)
        ->getLegend()->toBeNull()
        ->legend(fn ($legend) => $legend)->toBe($this->chart)
        ->getLegend()->toBeInstanceOf(Legend::class)
        ->legend(null)->toBe($this->chart)
        ->getLegend()->toBeNull()
        ->legend(Legend::make())->toBe($this->chart)
        ->getLegend()->toBeInstanceOf(Legend::class);
});
