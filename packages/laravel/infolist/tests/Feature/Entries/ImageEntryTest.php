<?php

use Honed\Infolist\Entries\ImageEntry;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->entry = ImageEntry::make('avatar');
});

it('has text type', function () {
    expect($this->entry)
        ->getType()->toBe(ImageEntry::IMAGE);
});

it('has array representation', function () {
    expect($this->entry->toArray())
        ->toBeArray()
        ->toEqual([
            'type' => ImageEntry::IMAGE,
            'label' => 'Avatar',
            'state' => null,
            'placehold' => null,
            'badge' => null,
            'variant' => null,
            'shape' => null,
        ]);
});

it('serializes to json', function () {
    expect($this->entry->jsonSerialize())
        ->toBeArray()
        ->toEqual([
            'type' => ImageEntry::IMAGE,
            'label' => 'Avatar',
        ]);
});