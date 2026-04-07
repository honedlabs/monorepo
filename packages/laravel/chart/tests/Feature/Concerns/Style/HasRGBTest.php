<?php

declare(strict_types=1);

use Honed\Chart\Style\Rgb;

beforeEach(function () {
    $this->rgb = Rgb::make();
});

it('has rgb channels', function () {
    expect($this->rgb)
        ->getRed()->toBe(0)
        ->getGreen()->toBe(0)
        ->getBlue()->toBe(0)
        ->red(10)->toBe($this->rgb)
        ->getRed()->toBe(10)
        ->rgb(20, 30, 40)->toBe($this->rgb)
        ->getRed()->toBe(20)
        ->getGreen()->toBe(30)
        ->getBlue()->toBe(40);
});
