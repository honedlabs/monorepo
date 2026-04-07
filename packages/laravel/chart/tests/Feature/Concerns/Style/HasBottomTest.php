<?php

declare(strict_types=1);

use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('has bottom', function () {
    expect($this->title)
        ->getBottom()->toBeNull()
        ->bottom('5%')->toBe($this->title)
        ->getBottom()->toBe('5%');
});
