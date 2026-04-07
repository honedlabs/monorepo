<?php

declare(strict_types=1);

use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has array representation', function () {
    expect($this->textStyle)
        ->toArray()->toEqual([]);
});