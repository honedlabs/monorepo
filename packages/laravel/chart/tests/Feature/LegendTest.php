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