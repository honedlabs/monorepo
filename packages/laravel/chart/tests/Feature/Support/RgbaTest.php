<?php

declare(strict_types=1);

use Honed\Chart\Style\Rgba;

it('has alpha', function () {
    $rgba = Rgba::make(255, 255, 255, 1);

    expect($rgba)
        ->getAlpha()->toBe(1)
        ->alpha(0)->toBe($rgba)
        ->getAlpha()->toBe(0);
});

it('validates alpha', function () {
    Rgba::make(255, 255, 255, 2);
})->throws(Exception::class);

it('can be created', function () {
    expect(Rgba::make(255, 255, 255, 1))
        ->toBeInstanceOf(Rgba::class)
        ->toString()->toBe('rgba(255, 255, 255, 1)')
        ->value()->toBe('rgba(255, 255, 255, 1)');
});
