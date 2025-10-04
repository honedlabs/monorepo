<?php

declare(strict_types=1);

use Honed\Infolist\Entries\TextEntry;

beforeEach(function () {
    $this->entry = TextEntry::make('name');
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
        ->format(123)->toBe('123');
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

it('can pipeline', function () {
    expect($this->entry
        ->limit(7)
        ->words(1)
        ->prefix('Mr. ')
        ->suffix(' Jr.')
    )
        ->format('John Doe')->toBe('Mr. John... Jr.');
});
