<?php

declare(strict_types=1);

use Honed\Infolist\Entries\DateEntry;
use Honed\Infolist\Formatters\DateFormatter;

beforeEach(function () {
    $this->entry = DateEntry::make('created_at');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBe('date')
        ->getFormatter()->toBeInstanceOf(DateFormatter::class);
});
