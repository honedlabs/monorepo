<?php

declare(strict_types=1);

use Honed\Chart\LineStyle;

beforeEach(function () {
    $this->lineStyle = LineStyle::make();
});

it('has dash offset', function () {
    expect($this->lineStyle)
        ->getDashOffset()->toBeNull()
        ->dashOffset(5)->toBe($this->lineStyle)
        ->getDashOffset()->toBe(5);
});
