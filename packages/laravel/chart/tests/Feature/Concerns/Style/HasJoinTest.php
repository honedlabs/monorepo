<?php

declare(strict_types=1);

use Honed\Chart\Enums\Join;
use Honed\Chart\LineStyle;

beforeEach(function () {
    $this->lineStyle = LineStyle::make();
});

it('has join', function () {
    expect($this->lineStyle)
        ->getJoin()->toBeNull()
        ->bevel()->toBe($this->lineStyle)
        ->getJoin()->toBe(Join::Bevel->value)
        ->join(Join::Round)->toBe($this->lineStyle)
        ->getJoin()->toBe(Join::Round->value);
});
