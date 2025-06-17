<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;
use Honed\Infolist\Infolist;

beforeEach(function () {
    $this->infolist = Infolist::make();
});

it('adds entries', function () {
    expect($this->infolist)
        ->entries(Entry::make('name'))
        ->entries([Entry::make('email')])
        ->getEntries()->toBeArray()
        ->toHaveCount(2);
});

it('adds entry', function () {
    expect($this->infolist)
        ->entry(Entry::make('name'))
        ->getEntries()->toBeArray()
        ->toHaveCount(1);
});

it('has entries to array', function () {
    expect($this->infolist)
        ->entries(Entry::make('name'))
        ->entriesToArray()->toBeArray()
        ->toHaveCount(1);
});

it('authorizes entries when arrayifying', function () {
    expect($this->infolist)
        ->entry(Entry::make('name')->allow(fn () => false))
        ->entry(Entry::make('email')->allow(fn () => true))
        ->entriesToArray()->toBeArray()
        ->toHaveCount(1);
});
