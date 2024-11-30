<?php

use Honed\Core\Formatters\NumberFormatter;

beforeEach(function () {
    $this->formatter = NumberFormatter::make();
});

it('has no divide by value by default', function () {
    expect($this->formatter->hasDivideBy())->toBeFalse();
    expect($this->formatter->missingDivideBy())->toBeTrue();
});

it('can set a divide by value', function () {
    expect($this->formatter->divideBy(100))->toBeInstanceOf(NumberFormatter::class)
        ->getDivideBy()->toBe(100);
});

it('can be set using setter', function () {
    $this->formatter->setDivideBy(100);
    expect($this->formatter->getDivideBy())->toBe(100);
});

it('does not accept null values', function () {
    $this->formatter->setDivideBy(100);
    $this->formatter->setDivideBy(null);
    expect($this->formatter->getDivideBy())->toBe(100);
});

