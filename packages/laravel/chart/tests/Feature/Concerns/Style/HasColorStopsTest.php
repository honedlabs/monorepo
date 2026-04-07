<?php

declare(strict_types=1);

use Honed\Chart\Style\ColorStop;
use Honed\Chart\Style\Gradient;

beforeEach(function () {
    $this->gradient = new Gradient();
});

it('has color stops', function () {
    expect($this->gradient)
        ->getColorStops()->toEqual([])
        ->colorStop(ColorStop::make('#f00', 0), ColorStop::make('#00f', 1))->toBe($this->gradient)
        ->getColorStops()->toHaveCount(2);
});
