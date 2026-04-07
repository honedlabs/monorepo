<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Grid;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can have grid', function () {
    expect($this->chart)
        ->getGrid()->toBeNull()
        ->grid()->toBe($this->chart)
        ->getGrid()->toBeInstanceOf(Grid::class)
        ->grid(false)->toBe($this->chart)
        ->getGrid()->toBeNull()
        ->grid(fn ($grid) => $grid)->toBe($this->chart)
        ->getGrid()->toBeInstanceOf(Grid::class)
        ->grid(null)->toBe($this->chart)
        ->getGrid()->toBeNull()
        ->grid(Grid::make())->toBe($this->chart)
        ->getGrid()->toBeInstanceOf(Grid::class);
});
