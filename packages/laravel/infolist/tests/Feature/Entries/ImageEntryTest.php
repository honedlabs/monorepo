<?php

declare(strict_types=1);

use Honed\Infolist\Entries\ImageEntry;

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
        ]);
});

it('serializes to json', function () {
    expect($this->entry->jsonSerialize())
        ->toBeArray()
        ->toEqual($this->entry->toArray());
});
