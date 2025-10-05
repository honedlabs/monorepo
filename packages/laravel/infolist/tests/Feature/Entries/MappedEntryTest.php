<?php

declare(strict_types=1);

use Honed\Infolist\Entries\MappedEntry;
use Honed\Infolist\Formatters\MappedFormatter;

beforeEach(function () {
    $this->entry = MappedEntry::make('status');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBeNull()
        ->defaultFormatter()->toBeInstanceOf(MappedFormatter::class);
});
