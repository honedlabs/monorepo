<?php

declare(strict_types=1);

use Honed\Chart\Legend;

beforeEach(function () {
    $this->legend = Legend::make();
});

it('has array representation', function () {
    expect($this->legend)
        ->toArray()->toEqual([]);
});

it('has labels', function () {
    $names = ['A', 'B', 'C'];

    expect($this->legend)
        ->getLabels()->toBeNull()
        ->labels($names)->toBe($this->legend)
        ->getLabels()->toEqual($names);

    expect($this->legend->toArray()['data'])->toEqual($names);
});
