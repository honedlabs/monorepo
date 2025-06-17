<?php

declare(strict_types=1);

use Honed\Infolist\Infolist;
use Illuminate\Support\Str;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->infolist = Infolist::make($this->user);
});

afterEach(function () {
    Infolist::flushState();
});

it('has resource', function () {
    expect($this->infolist)
        ->getResource()->toBe($this->user)
        ->for($this->user)->toBe($this->infolist)
        ->getResource()->toBe($this->user);
});

it('resolves infolist for model', function () {
    expect(Infolist::resolveInfolistName(User::class))
        ->toBe('App\\Infolists\\Models\\UserInfolist');

    Infolist::guessInfolistsUsing(fn (string $className) => Str::of($className)
        ->classBasename()
        ->prepend('Workbench\\App\\Infolists\\')
        ->append('Infolist')
        ->toString()
    );
});

it('can use a custom namespace', function () {
    Infolist::useNamespace('Workbench\\App\\Infolists\\');

    expect(Infolist::resolveInfolistName(User::class))
        ->toBe('Workbench\\App\\Infolists\\Models\\UserInfolist');
});

it('has array representation', function () {
    expect($this->infolist->toArray())
        ->toBeArray()
        ->toBeEmpty();
});
