<?php

declare(strict_types=1);

use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('has z', function () {
    expect($this->title)
        ->getZ()->toBeNull()
        ->z(7)->toBe($this->title)
        ->getZ()->toBe(7);
});
