<?php

declare(strict_types=1);

use Honed\Infolist\Infolist;
use Illuminate\Support\Str;
use Workbench\App\Infolists\UserInfolist;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->infolist = Infolist::make($this->user);
});

afterEach(function () {
    Infolist::flushState();
});

it('resolves table', function () {
    Infolist::guessInfolistsUsing(function ($class) {
        return Str::of($class)
            ->classBasename()
            ->prepend('Workbench\\App\\Infolists\\')
            ->append('Infolist')
            ->value();
    });

    expect(Infolist::resolveInfolistName(User::class))
        ->toBe(UserInfolist::class);

    expect(Infolist::infolistForModel(User::factory()->create()))
        ->toBeInstanceOf(UserInfolist::class);
});

it('uses namespace', function () {
    Infolist::useNamespace('');

    expect(Infolist::resolveInfolistName(User::class))
        ->toBe(Str::of(UserInfolist::class)
            ->classBasename()
            ->prepend('Models\\')
            ->value()
        );
});

it('has array representation', function () {
    expect($this->infolist->toArray())
        ->toBeArray()
        ->toBeEmpty();
});
