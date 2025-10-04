<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\CurrencyFormatter;

beforeEach(function () {
    $this->formatter = new CurrencyFormatter();
});

it('has currency', function () {
    expect($this->formatter)
        ->getCurrency()->toBeNull()
        ->currency('usd')->toBe($this->formatter)
        ->getCurrency()->toBe('USD');
});

it('has divide', function () {
    expect($this->formatter)
        ->getDivide()->toBeNull()
        ->divide(10)->toBe($this->formatter)
        ->getDivide()->toBe(10)
        ->cents()->toBe($this->formatter)
        ->getDivide()->toBe(100);
});

it('handles null values', function () {
    expect($this->formatter)
        ->format(null)->toBeNull();
});

it('handles non-numeric values', function () {
    expect($this->formatter)
        ->format(true)->toBeNull()
        ->format(new stdClass())->toBeNull()
        ->format([])->toBeNull();
});

it('formats values', function () {
    expect($this->formatter)
        ->currency('usd')->toBe($this->formatter)
        ->format(100)->toBe('$100.00')
        ->format(100.00)->toBe('$100.00')
        ->format('100')->toBe('$100.00')
        ->divide(10)->toBe($this->formatter)
        ->format(100)->toBe('$10.00')
        ->cents()->toBe($this->formatter)
        ->format(100)->toBe('$1.00');
});
