<?php

declare(strict_types=1);

use Honed\Chart\Series\Line;

beforeEach(function () {
    $this->series = Line::make();
});

it('can be smooth', function () {
    expect($this->series)
        ->isSmooth()->toBeNull()
        ->smooth()->toBe($this->series)
        ->isSmooth()->toBeTrue()
        ->dontSmooth()->toBe($this->series)
        ->isSmooth()->toBeFalse();
});
