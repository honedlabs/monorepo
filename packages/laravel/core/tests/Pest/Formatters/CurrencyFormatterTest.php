<?php

use Honed\Core\Formatters\CurrencyFormatter;
use Illuminate\Support\Number;

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

it('formats a currency', function () {
    $this->formatter->setCurrency('AUD');
    $this->formatter->setLocale('au');
    expect($this->formatter->format(10000))->toBe(Number::currency(10000 / 100, 'AUD', 'au'));
});

it('casts non-numeric values', function () {
    expect($this->formatter->format('1234567'))->toBe(Number::currency(1234567 / 100));
});

it('does not format non-numeric values', function () {
    expect($this->formatter->format('testing'))->toBeNull();
});

it('has shorthand `cents`', function () {
    $this->formatter->cents();
    expect($this->formatter->getDivideBy())->toBe(100);
});

it('has shorthand `dollars`', function () {
    $this->formatter->dollars();
    expect($this->formatter->getDivideBy())->toBe(1);
});
