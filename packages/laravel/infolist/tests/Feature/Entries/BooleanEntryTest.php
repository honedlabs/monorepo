<?php

declare(strict_types=1);

use Honed\Infolist\Entries\BooleanEntry;

beforeEach(function () {
    $this->entry = BooleanEntry::make('is_active');
});

it('has text type', function () {
    expect($this->entry)
        ->getType()->toBe(BooleanEntry::BOOLEAN);
});

it('has array representation', function () {
    expect($this->entry->toArray())
        ->toBeArray()
        ->toEqual([
            'type' => BooleanEntry::BOOLEAN,
            'label' => 'Is active',
        ]);
});

it('serializes to json', function () {
    expect($this->entry->jsonSerialize())
        ->toBeArray()
        ->toEqual($this->entry->toArray());
});
