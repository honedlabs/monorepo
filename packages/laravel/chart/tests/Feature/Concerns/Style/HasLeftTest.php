<?php

declare(strict_types=1);

use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('has left', function () {
    expect($this->title)
        ->getLeft()->toBeNull()
        ->left('10px')->toBe($this->title)
        ->getLeft()->toBe('10px');
});
