<?php

declare(strict_types=1);

use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('has z level', function () {
    expect($this->title)
        ->getZLevel()->toBeNull()
        ->zLevel(3)->toBe($this->title)
        ->getZLevel()->toBe(3);
});
