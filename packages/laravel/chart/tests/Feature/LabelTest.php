<?php

declare(strict_types=1);

use Honed\Chart\Label;

beforeEach(function () {
    $this->label = Label::make();
});

it('has array representation', function () {
    expect($this->label)
        ->toArray()->toEqual([]);
});