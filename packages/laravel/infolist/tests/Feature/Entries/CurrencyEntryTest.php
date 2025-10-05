<?php

declare(strict_types=1);

use Honed\Infolist\Entries\CurrencyEntry;
use Honed\Infolist\Formatters\CurrencyFormatter;

beforeEach(function () {
    $this->entry = CurrencyEntry::make('price');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBe('numeric')
        ->defaultFormatter()->toBeInstanceOf(CurrencyFormatter::class);
});
