<?php

declare(strict_types=1);

use Honed\Infolist\Entries\ImageEntry;
use Honed\Infolist\Formatters\ImageFormatter;

beforeEach(function () {
    $this->entry = ImageEntry::make('avatar');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBe('image')
        ->getFormatter()->toBeInstanceOf(ImageFormatter::class);
});
