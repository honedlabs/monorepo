<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;

beforeEach(function () {
    $this->entry = Entry::make('name');
});

it('can have classes', function () {
    expect($this->entry)
        ->getClasses()->toBeNull()
        ->classes('bg-red-500')
        ->getClasses()->toBe('bg-red-500')
        ->classes('bg-blue-500')
        ->getClasses()->toBe('bg-red-500 bg-blue-500');
});

it('evaluates classes', function () {
    $entry = Entry::make('name')
        ->classes('bg-red-500')
        ->classes(fn () => 'bg-blue-500');

    expect($entry)
        ->getClasses()->toBe('bg-red-500 bg-blue-500');
});
