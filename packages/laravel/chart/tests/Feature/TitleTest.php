<?php

declare(strict_types=1);

use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('has array representation', function () {
    expect($this->title)
        ->toArray()->toEqual([]);
});