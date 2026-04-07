<?php

declare(strict_types=1);

use Honed\Chart\Enums\GradientType;
use Honed\Chart\Style\Gradient;

beforeEach(function () {
    $this->gradient = new Gradient();
});

it('has gradient type', function () {
    expect($this->gradient)
        ->getType()->toBe(GradientType::Linear->value)
        ->radial()->toBe($this->gradient)
        ->getType()->toBe(GradientType::Radial->value)
        ->linear()->toBe($this->gradient)
        ->getType()->toBe(GradientType::Linear->value)
        ->type(GradientType::Radial)->toBe($this->gradient)
        ->getType()->toBe(GradientType::Radial->value);
});
