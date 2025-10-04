<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;

beforeEach(function () {
    $this->entry = Entry::make('name');
});

it('can be badge', function () {
    expect($this->entry)
        ->isBadge()->toBeNull()
        ->badge()->toBe($this->entry)
        ->isBadge()->toBeTrue();
});

it('can have variant', function () {
    expect($this->entry)
        ->getVariant()->toBeNull()
        ->variant('primary')
        ->getVariant()->toBeNull()
        ->badge()->toBe($this->entry)
        ->getVariant()->toBe('primary');
});
