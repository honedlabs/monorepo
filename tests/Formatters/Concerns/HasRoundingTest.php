<?php

use Honed\Core\Formatters\NumberFormatter;

beforeEach(function () {
    $this->formatter = NumberFormatter::make();
});

it('has no rounding value by default', function () {
    expect($this->formatter->hasRounding())->toBeFalse();
    expect($this->formatter->missingRounding())->toBeTrue();
});

it('can set a rounding value', function () {
    expect($this->formatter->rounding(100))->toBeInstanceOf(NumberFormatter::class)
        ->getRounding()->toBe(100);
});

it('can be set using setter', function () {
    $this->formatter->setRounding(100);
    expect($this->formatter->getRounding())->toBe(100);
});

it('does not accept null values', function () {
    $this->formatter->setRounding(100);
    $this->formatter->setRounding(null);
    expect($this->formatter->getRounding())->toBe(100);
});

