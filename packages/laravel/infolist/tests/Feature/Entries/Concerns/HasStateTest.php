<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->entry = Entry::make('misc');
});

it('can have record', function () {
    $user = User::factory()->create();

    expect($this->entry)
        ->getRecord()->toBeNull()
        ->record($user)->toBe($this->entry)
        ->getRecord()->toBeInstanceOf(User::class)
        ->getState()->toBeNull();
});

it('can have string state', function () {
    $user = User::factory()->create();

    expect($this->entry)
        ->getState()->toBeNull()
        ->state('name')->toBe($this->entry)
        ->record($user)->toBe($this->entry)
        ->getState()->toBe($user->name);
});

it('can have closure state', function () {
    $user = User::factory()->create();

    expect($this->entry)
        ->getState()->toBeNull()
        ->state(fn () => $user->name)->toBe($this->entry)
        ->record($user)->toBe($this->entry)
        ->getState()->toBe($user->name);
});
