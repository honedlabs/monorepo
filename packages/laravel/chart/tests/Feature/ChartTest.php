<?php

declare(strict_types=1);

use Honed\Chart\Chart;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can flip axes', function () {
    expect($this->chart)
        ->isFlipped()->toBeFalse()
        ->flip()->toBe($this->chart)
        ->isFlipped()->toBeTrue()
        ->flip(false)->toBe($this->chart)
        ->isFlipped()->toBeFalse()
        ->dontflip()->toBe($this->chart)
        ->isFlipped()->toBeFalse();
});
