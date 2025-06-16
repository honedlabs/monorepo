<?php

use Honed\Infolist\Entries\TextEntry;
use Workbench\App\Models\User;

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
            'state' => null,
            'placehold' => null,
            'badge' => null,
            'variant' => null,
        ]);
});

it('serializes to json', function () {
    expect($this->entry->jsonSerialize())
        ->toBeArray()
        ->toEqual([
            'type' => TextEntry::TEXT,
            'label' => 'Name',
        ]);
});

it('does not format null values', function () {
    expect($this->entry)
        ->format(null)->toBeNull();
});

it('does not format by default', function () {
    expect($this->entry)
        ->format('John Doe')->toBe('John Doe');
});

it('does not format non-string values', function () {
    expect($this->entry)
        ->format(123)->toBeNull();
});

it('can limit the text', function () {
    expect($this->entry)
        ->limit(7)->toBe($this->entry)
        ->format('John Doe')->toBe('John Do...');
});

it('can limit the words', function () {
    expect($this->entry)
        ->words(1)->toBe($this->entry)
        ->format('John Doe')->toBe('John...');
});

it('can prefix the text', function () {
    expect($this->entry)
        ->prefix('Mr. ')->toBe($this->entry)
        ->format('John Doe')->toBe('Mr. John Doe');
});

it('can suffix the text', function () {
    expect($this->entry)
        ->suffix(' Jr.')->toBe($this->entry)
        ->format('John Doe')->toBe('John Doe Jr.');
});

it('can separate the text', function () {
    expect($this->entry)
        ->separator(' ')->toBe($this->entry)
        ->format('John Doe')->toEqual(['John', 'Doe']);
});

it('can use all formatters', function () {
    expect($this->entry
            ->limit(7)
            ->words(1)
            ->prefix('Mr. ')
            ->suffix(' Jr.')
        )
        ->format('John Doe')->toBe('Mr. John... Jr.');
});