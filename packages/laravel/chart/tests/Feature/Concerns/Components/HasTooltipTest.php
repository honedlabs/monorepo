<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Tooltip;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can have tooltip', function () {
    expect($this->chart)
        ->getTooltip()->toBeNull()
        ->tooltip()->toBe($this->chart)
        ->getTooltip()->toBeInstanceOf(Tooltip::class)
        ->tooltip(false)->toBe($this->chart)
        ->getTooltip()->toBeNull()
        ->tooltip(fn ($tooltip) => $tooltip)->toBe($this->chart)
        ->getTooltip()->toBeInstanceOf(Tooltip::class)
        ->tooltip(null)->toBe($this->chart)
        ->getTooltip()->toBeNull()
        ->tooltip(Tooltip::make())->toBe($this->chart)
        ->getTooltip()->toBeInstanceOf(Tooltip::class);
});
