<?php

declare(strict_types=1);

use Honed\Chart\ShadowStyle;

beforeEach(function () {
    $this->shadowStyle = ShadowStyle::make();
});

it('has array representation', function () {
    expect($this->shadowStyle)
        ->toArray()->toEqual([]);
});