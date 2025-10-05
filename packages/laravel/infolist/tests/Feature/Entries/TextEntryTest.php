<?php

declare(strict_types=1);

use Honed\Infolist\Entries\TextEntry;
use Honed\Infolist\Formatters\TextFormatter;

beforeEach(function () {
    $this->entry = TextEntry::make('title');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBe('text')
        ->defaultFormatter()->toBeInstanceOf(TextFormatter::class);
});
