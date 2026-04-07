<?php

declare(strict_types=1);

use Honed\Chart\Toolbox;

beforeEach(function () {
    $this->toolbox = Toolbox::make();
});

it('has array representation', function () {
    expect($this->toolbox)
        ->toArray()->toEqual([]);
});