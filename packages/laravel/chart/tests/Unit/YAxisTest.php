<?php

declare(strict_types=1);

use Honed\Chart\YAxis;

it('has y axis', function () {
    expect(YAxis::make())
        ->getType()->toBe('y');
});