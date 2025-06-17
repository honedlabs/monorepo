<?php

declare(strict_types=1);

use Honed\Infolist\Entries\ArrayEntry;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->entry = ArrayEntry::make('users');
});

it('can pluck', function () {
    expect($this->entry)
        ->getPluck()->toBeNull()
        ->pluck('name')
        ->getPluck()->toBe('name')
        ->format(User::factory(10)->create())
        ->scoped(fn ($entry) => $entry
            ->toBeArray()
            ->toHaveCount(10)
            ->each->toBeString()
        );
});

it('can glue', function () {
    expect($this->entry)
        ->getGlue()->toBeNull()
        ->glue(', ')
        ->getGlue()->toBe(', ')
        ->format(['a', 'b', 'c'])
        ->toBe('a, b, c');
});

it('can pipeline', function () {
    expect($this->entry)
        ->pluck('name')
        ->glue(', ')
        ->format(User::factory(10)->create())
        ->toBeString();
});
