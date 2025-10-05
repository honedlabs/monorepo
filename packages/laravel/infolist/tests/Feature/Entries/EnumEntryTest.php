<?php

declare(strict_types=1);

use Honed\Infolist\Entries\EnumEntry;
use Honed\Infolist\Formatters\EnumFormatter;

beforeEach(function () {
    $this->entry = EnumEntry::make('status');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBeNull()
        ->defaultFormatter()->toBeInstanceOf(EnumFormatter::class);
});
