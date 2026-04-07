<?php

declare(strict_types=1);

use Honed\Chart\AreaStyle;

beforeEach(function () {
    $this->areaStyle = AreaStyle::make();
});

it('has opacity', function () {
    expect($this->areaStyle)
        ->getOpacity()->toBeNull()
        ->opacity(65)->toBe($this->areaStyle)
        ->getOpacity()->toBe(65);
});
