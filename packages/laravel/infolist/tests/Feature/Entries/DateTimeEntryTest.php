<?php

declare(strict_types=1);

use Honed\Infolist\Entries\DateTimeEntry;
use Honed\Infolist\Formatters\DateTimeFormatter;

beforeEach(function () {
    $this->entry = DateTimeEntry::make('created_at');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBe('datetime')
        ->defaultFormatter()->toBeInstanceOf(DateTimeFormatter::class);
});
