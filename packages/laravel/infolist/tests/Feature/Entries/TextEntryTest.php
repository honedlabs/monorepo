<?php

declare(strict_types=1);

use Honed\Infolist\Entries\TextEntry;

beforeEach(function () {
    $this->entry = TextEntry::make('name');
});

it('has text type', function () {
    expect($this->entry)
        ->getType()->toBe(TextEntry::TEXT);
});

it('has array representation', function () {
    expect($this->entry->toArray())
        ->toBeArray()
        ->toEqual([
            'type' => TextEntry::TEXT,
            'label' => 'Name',
        ]);
});

it('serializes to json', function () {
    expect($this->entry->jsonSerialize())
        ->toBeArray()
        ->toEqual($this->entry->toArray());
});
