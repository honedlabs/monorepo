<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;
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

it('has array representation', function () {
    expect($this->entry->toArray())
        ->toBeArray()
        ->toEqual([
            'label' => 'Name',
            'state' => $this->user->name,
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
