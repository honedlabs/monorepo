<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;
use Honed\Infolist\Entries\NumericEntry;
use Illuminate\Database\Eloquent\Model;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->entry = Entry::make('name')->record($this->user);
});

it('makes an entry', function () {
    expect(Entry::make('name'))
        ->getStateResolver()->toBe('name')
        ->getState()->toBeNull()
        ->getLabel()->toBe('Name');
});

it('has before formatting callback', function () {
    expect($this->entry)
        ->apply(1)->toBe([1, false])
        ->beforeFormatting(fn ($value) => $value * 2)->toBe($this->entry)
        ->apply(1)->toBe([2, false]);
});

it('has after formatting callback', function () {
    expect($this->entry)
        ->apply(1)->toBe([1, false])
        ->afterFormatting(fn ($value) => $value * 2)->toBe($this->entry)
        ->apply(1)->toBe([2, false])
        ->apply(null)->toBe([null, true]);
});

it('can have string state', function () {
    $user = User::factory()->create();

    expect($this->entry)
        ->getStateResolver()->toBe('name')
        ->state('name')->toBe($this->entry)
        ->record($user)->toBe($this->entry)
        ->getState()->toBe($user->name);
});

it('can have closure state', function () {
    $user = User::factory()->create();

    expect($this->entry)
        ->getStateResolver()->toBe('name')
        ->state(fn () => $user->name)->toBe($this->entry)
        ->record($user)->toBe($this->entry)
        ->getState()->toBe($user->name);
});

it('is macroable', function () {
    Entry::macro('test', function () {
        return 'test';
    });

    expect($this->entry)
        ->test()->toBe('test');
});

it('forwards calls to the formatter', function () {
    $entry = NumericEntry::make('amount');

    expect($entry)
        ->decimals(2)->toBe($entry)
        ->getDecimals()->toBe(2);
});

it('has array representation', function () {
    expect($this->entry->toArray())
        ->toBeArray()
        ->toEqualCanonicalizing([
            'name' => 'name',
            'label' => 'Name',
            'value' => [
                'v' => $this->user->name,
                'f' => false,
            ],
        ]);
});

it('has array representation with placeholder', function () {
    expect($this->entry->placeholder('N/A')->record([])->toArray())
        ->toBeArray()
        ->toEqual($this->entry->toArray());
});

it('serializes to json', function () {
    expect($this->entry->jsonSerialize())
        ->toBeArray()
        ->toEqual($this->entry->toArray());
});

it('serializes to json with placeholder', function () {
    expect($this->entry->placeholder('N/A')->record([])->jsonSerialize())
        ->toBeArray()
        ->toEqual($this->entry->toArray());
});

it('resolves named closure dependencies', function ($callback, $expected) {
    expect($this->entry)
        ->evaluate($callback)->toBe($expected);
})->with([
    fn () => [fn ($record) => $record, $this->user],
    fn () => [fn ($row) => $row, $this->user],
    fn () => [fn ($state) => $state, $this->user->name],
]);

it('resolves typed closure dependencies', function ($callback, $expected) {
    expect($this->entry)
        ->evaluate($callback)->toBe($expected);
})->with([
    fn () => [fn (User $t) => $t, $this->user],
    fn () => [fn (Model $t) => $t, $this->user],
]);
