<?php

use Honed\Core\Formatters\NumberFormatter;
use Illuminate\Support\Number;

beforeEach(function () {
    $this->formatter = NumberFormatter::make();
});

it('can be made', function () {
    $formatter = NumberFormatter::make();
    expect($formatter)->toBeInstanceOf(NumberFormatter::class);
});

it('accepts a precision, divide by, and locale', function () {
    $formatter = NumberFormatter::make(2, 1000, 'au');
    expect($formatter->getPrecision())->toBe(2);
    expect($formatter->getDivideBy())->toBe(1000);
    expect($formatter->getLocale())->toBe('au');
});

it('formats a number', function () {
    $this->formatter->setPrecision(2);
    $this->formatter->setLocale('au');
    expect($this->formatter->format(1234567))->toBe(Number::format(1234567, precision: 2, locale: 'au'));
});

it('casts non-numeric values', function () {
    $this->formatter->setPrecision(2);
    $this->formatter->setLocale('au');
    expect($this->formatter->format('1234567'))->toBe(Number::format(1234567, precision: 2, locale: 'au'));
});

it('does not format non-numeric values', function () {
    expect($this->formatter->format('testing'))->toBeNull();
});
