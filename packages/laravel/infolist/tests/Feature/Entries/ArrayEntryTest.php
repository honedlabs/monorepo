<?php

declare(strict_types=1);

use Honed\Infolist\Entries\ArrayEntry;

beforeEach(function () {
    $this->entry = ArrayEntry::make('products');
});

it('has text type', function () {
    expect($this->entry)
        ->getType()->toBe(ArrayEntry::ARRAY);
});

it('has array representation', function () {
    expect($this->entry->toArray())
        ->toBeArray()
        ->toEqual([
            'type' => ArrayEntry::ARRAY,
            'label' => 'Products',
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
            'type' => ArrayEntry::ARRAY,
            'label' => 'Products',
        ]);
});

it('does not format null values', function () {
    expect($this->entry)
        ->format(null)->toBeNull();
});
