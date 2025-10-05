<?php

declare(strict_types=1);

use Honed\Infolist\Entries\TimeEntry;
use Honed\Infolist\Formatters\TimeFormatter;

beforeEach(function () {
    $this->entry = TimeEntry::make('created_at');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBe('time')
        ->defaultFormatter()->toBeInstanceOf(TimeFormatter::class);
});
