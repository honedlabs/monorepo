<?php

declare(strict_types=1);

use Honed\Infolist\Entries\BooleanEntry;
use Honed\Infolist\Formatters\BooleanFormatter;

beforeEach(function () {
    $this->entry = BooleanEntry::make('is_active');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBe('boolean')
        ->defaultFormatter()->toBeInstanceOf(BooleanFormatter::class);
});
