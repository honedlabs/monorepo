<?php

declare(strict_types=1);

use Honed\Infolist\Entries\ArrayEntry;
use Honed\Infolist\Formatters\ArrayFormatter;

beforeEach(function () {
    $this->entry = ArrayEntry::make('products');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBe('array')
        ->defaultFormatter()->toBeInstanceOf(ArrayFormatter::class);
});
