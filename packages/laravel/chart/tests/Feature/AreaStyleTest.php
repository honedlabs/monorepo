<?php

declare(strict_types=1);

use Honed\Chart\AreaStyle;

beforeEach(function () {
    $this->areaStyle = AreaStyle::make();
});

it('has array representation', function () {
    expect($this->areaStyle)
        ->toArray()->toEqual([]);
});