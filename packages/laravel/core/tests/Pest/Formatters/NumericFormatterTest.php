<?php

use Honed\Core\Formatters\NumericFormatter;
use Illuminate\Support\Number;

beforeEach(function () {
    $this->formatter = NumericFormatter::make();
});

it('makes', function () {
    expect(NumericFormatter::make())
        ->toBeInstanceOf(NumericFormatter::class);
});

it('sets precision', function () {
    expect($this->formatter->precision(2))
        ->toBeInstanceOf(NumericFormatter::class)
        ->getPrecision()->toBe(2)
        ->hasPrecision()->toBeTrue();
});

it('sets divide by', function () {
    expect($this->formatter->divideBy(1000))
        ->toBeInstanceOf(NumericFormatter::class)
        ->getDivideBy()->toBe(1000)
        ->hasDivideBy()->toBeTrue();
});

it('sets locale', function () {
    expect($this->formatter->locale('au'))
        ->toBeInstanceOf(NumericFormatter::class)
        ->getLocale()->toBe('au')
        ->hasLocale()->toBeTrue();
});

it('sets currency', function () {
    expect($this->formatter->currency('USD'))
        ->toBeInstanceOf(NumericFormatter::class)
        ->getCurrency()->toBe('USD')
        ->hasCurrency()->toBeTrue();
});

it('sets cents', function () {
    expect($this->formatter->cents())
        ->toBeInstanceOf(NumericFormatter::class)
        ->getDivideBy()->toBe(100)
        ->hasDivideBy()->toBeTrue();
});

it('formats', function () {
    expect($this->formatter->format(1000))
        ->toBe(1000);

    expect($this->formatter->divideBy(100)->format(1000))
        ->toBe(10);

    expect($this->formatter->locale('au')->format(1000))
        ->toBe(Number::format(10, locale: 'au'));

    expect($this->formatter->currency('USD')->format(1000))
        ->toBe(Number::currency(10, 'USD', 'au'));

    expect($this->formatter->format(null))
        ->toBeNull();

    expect($this->formatter->format('testing'))
        ->toBeNull();
});
