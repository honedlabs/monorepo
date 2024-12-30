<?php

use Honed\Core\Formatters\NumberFormatter;

beforeEach(function () {
    $this->formatter = NumberFormatter::make();
});

it('has no precision value by default', function () {
    expect($this->formatter->hasPrecision())->toBeFalse();
});

it('can set a precision value', function () {
    expect($this->formatter->precision(100))->toBeInstanceOf(NumberFormatter::class)
        ->getPrecision()->toBe(100);
});

it('can be set using setter', function () {
    $this->formatter->setPrecision(100);
    expect($this->formatter->getPrecision())->toBe(100);
});

it('does not accept null values', function () {
    $this->formatter->setPrecision(100);
    $this->formatter->setPrecision(null);
    expect($this->formatter->getPrecision())->toBe(100);
});
