<?php

declare(strict_types=1);

use Honed\Chart\Style\Rgb;

it('can be created', function () {
    expect(Rgb::make(255, 255, 255))
        ->toBeInstanceOf(Rgb::class)
        ->toString()->toBe('rgb(255, 255, 255)')
        ->value()->toBe('rgb(255, 255, 255)');
});
