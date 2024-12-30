<?php

use Honed\Core\Formatters\CurrencyFormatter;

beforeEach(function () {
    $this->formatter = CurrencyFormatter::make();
});

it('has no currency by default', function () {
    expect($this->formatter->hascurrency())->toBeFalse();
});

it('can set a currency', function () {
    expect($this->formatter->currency('USD'))->toBeInstanceOf(CurrencyFormatter::class)
        ->getcurrency()->toBe('USD');
});

it('can be set using setter', function () {
    $this->formatter->setcurrency('USD');
    expect($this->formatter->getcurrency())->toBe('USD');
});

it('does not accept null values', function () {
    $this->formatter->setcurrency('USD');
    $this->formatter->setcurrency(null);
    expect($this->formatter->getcurrency())->toBe('USD');
});
