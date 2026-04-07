<?php

declare(strict_types=1);

use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('has top', function () {
    expect($this->title)
        ->getTop()->toBeNull()
        ->top('2%')->toBe($this->title)
        ->getTop()->toBe('2%');
});
