<?php

declare(strict_types=1);

use Honed\Chart\Style\ColorStop;

beforeEach(function () {
    $this->colorStop = ColorStop::make('#000000', 0);
});

it('has offset', function () {
    expect($this->colorStop)
        ->getOffset()->toBe(0)
        ->offset(0.5)->toBe($this->colorStop)
        ->getOffset()->toBe(0.5)
        ->end()->toBe($this->colorStop)
        ->getOffset()->toBe(1)
        ->start()->toBe($this->colorStop)
        ->getOffset()->toBe(0);
});
