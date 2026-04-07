<?php

declare(strict_types=1);

use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('has right', function () {
    expect($this->title)
        ->getRight()->toBeNull()
        ->right(16)->toBe($this->title)
        ->getRight()->toBe(16);
});
