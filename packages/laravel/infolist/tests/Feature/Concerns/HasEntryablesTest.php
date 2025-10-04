<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;
use Honed\Infolist\Infolist;

beforeEach(function () {
    $this->infolist = Infolist::make();
});

it('adds entryables', function () {
    expect($this->infolist)
        ->entries(Entry::make('name'))
        ->entries([Entry::make('email')])
        ->getEntries()->toBeArray()
        ->toHaveCount(2);
});

it('adds entryable', function () {
    expect($this->infolist)
        ->entry(Entry::make('name'))
        ->getEntries()->toBeArray()
        ->toHaveCount(1);
});

it('authorizes entryables', function () {
    expect($this->infolist)
        ->entry(Entry::make('name')->allow(fn () => false))
        ->entry(Entry::make('email')->allow(fn () => true))
        ->getEntries()
        ->scoped(fn ($array) => $array
            ->toBeArray()
            ->toHaveCount(1)
        );
});
