<?php

declare(strict_types=1);

use Honed\Chart\XAxis;

it('has x axis', function () {
    expect(XAxis::make())
        ->getType()->toBe('x');
});