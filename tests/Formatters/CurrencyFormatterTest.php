<?php

use Illuminate\Support\Number;
use Honed\Core\Formatters\CurrencyFormatter;

beforeEach(function () {
    $this->formatter = CurrencyFormatter::make();
});

it('can be made', function () {
    $formatter = CurrencyFormatter::make();
    expect($formatter)->toBeInstanceOf(CurrencyFormatter::class);
});

it('accepts a currency, divide by, and locale', function () {
    $formatter = CurrencyFormatter::make('AUD', 100, 'au');
    expect($formatter->getCurrency())->toBe('AUD');
    expect($formatter->getDivideBy())->toBe(100);
    expect($formatter->getLocale())->toBe('au');
});

it('can format a currency', function () {
    $this->formatter->setCurrency('AUD');
    $this->formatter->setLocale('au');
    expect($this->formatter->format(10000))->toBe(Number::currency(10000 / 100, 'AUD', 'au'));
});

it('can cast non-numeric values', function () {
    expect($this->formatter->format('1234567'))->toBe(Number::currency(1234567 / 100));
});

it('does not format non-numeric values', function () {
    expect($this->formatter->format('testing'))->toBeNull();
});

it('has a shorthand for cents', function () {
    $this->formatter->cents();
    expect($this->formatter->getDivideBy())->toBe(100);
});

it('has a shorthand for dollars', function () {
    $this->formatter->dollars();
    expect($this->formatter->getDivideBy())->toBe(1);
});

