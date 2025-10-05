<?php

declare(strict_types=1);

use Honed\Infolist\Entries\ColorEntry;
use Honed\Infolist\Formatters\ColorFormatter;

beforeEach(function () {
    $this->entry = ColorEntry::make('color');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBe('color')
        ->defaultFormatter()->toBeInstanceOf(ColorFormatter::class);
});
