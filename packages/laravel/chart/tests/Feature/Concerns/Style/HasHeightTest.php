<?php

declare(strict_types=1);

use Honed\Chart\Legend;

beforeEach(function () {
    $this->legend = Legend::make();
});

it('has height', function () {
    expect($this->legend)
        ->getHeight()->toBeNull()
        ->height(48)->toBe($this->legend)
        ->getHeight()->toBe(48);
});
