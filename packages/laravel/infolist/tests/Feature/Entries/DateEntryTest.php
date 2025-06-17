<?php

declare(strict_types=1);

use Honed\Infolist\Entries\DateEntry;

beforeEach(function () {
    $this->entry = DateEntry::make('created_at');
});

it('has text type', function () {
    expect($this->entry)
        ->getType()->toBe(DateEntry::DATE);
});

it('has array representation', function () {
    expect($this->entry->toArray())
        ->toBeArray()
        ->toEqual([
            'type' => DateEntry::DATE,
            'label' => 'Created at',
            'state' => null,
            'placehold' => null,
            'badge' => null,
            'variant' => null,
            'class' => null,
        ]);
});

it('serializes to json', function () {
    expect($this->entry->jsonSerialize())
        ->toBeArray()
        ->toEqual([
            'type' => DateEntry::DATE,
            'label' => 'Created at',
        ]);
});

it('does not format null values', function () {
    expect($this->entry)
        ->format(null)->toBeNull();
});

it('does not format non-datetime values', function () {
    expect($this->entry)
        ->format('misc')->toBeNull();
});
