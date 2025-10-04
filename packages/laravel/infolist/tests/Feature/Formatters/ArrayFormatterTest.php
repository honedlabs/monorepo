<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\ArrayFormatter;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->formatter = new ArrayFormatter();
});

it('handles null values', function () {
    expect($this->formatter)
        ->format(null)->toBeNull();
});

it('handles non-array values', function () {
    expect($this->formatter)
        ->format('string')->toBeNull();
});

it('plucks', function () {
    expect($this->formatter)
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

it('glues', function () {
    expect($this->formatter)
        ->getGlue()->toBeNull()
        ->glue(', ')
        ->getGlue()->toBe(', ')
        ->format(['a', 'b', 'c'])
        ->toBe('a, b, c');
});

it('formats', function () {
    expect($this->formatter)
        ->pluck('name')->toBe($this->formatter)
        ->glue(', ')->toBe($this->formatter)
        ->format($users = User::factory(10)->create())->toBe($users->pluck('name')->join(', '));
});
