<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;

beforeEach(function () {
    $this->entry = Entry::make('name');
});

it('can have placeholder', function () {
    expect($this->entry)
        ->getPlaceholder()->toBeNull()
        ->placeholder('N/A')
        ->getPlaceholder()->toBe('N/A');
});
