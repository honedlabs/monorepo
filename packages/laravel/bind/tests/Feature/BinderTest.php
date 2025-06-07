<?php

declare(strict_types=1);

use App\Binders\AdminBinder;
use App\Binders\UserBinder;
use App\Models\User;
use Honed\Bind\Binder;
use Illuminate\Database\Eloquent\Builder;

beforeEach(function () {
    $this->artisan('bind:cache');

    Binder::flushState();
});

it('uses cache', function () {
    expect(Binder::for(User::class, 'edit'))
        ->toBeInstanceOf(UserBinder::class);
});

it('retrieves without cache', function () {
    $this->artisan('bind:clear');

    expect(Binder::for(User::class, 'edit'))
        ->toBeInstanceOf(UserBinder::class);
});

it('gets class name from attribute', function () {
    expect(UserBinder::getBindsAttribute())
        ->toBeNull();

    expect(AdminBinder::getBindsAttribute())
        ->toBe(User::class);
});

it('guesses model name', function () {
    Binder::guessModelNamesUsing(null);

    expect(Binder::for(User::class, 'edit'))
        ->toBeInstanceOf(UserBinder::class);
});

it('uses custom namespace', function () {
    Binder::useNamespace('App\\Binders\\');

    expect(Binder::for(User::class, 'edit'))
        ->toBeInstanceOf(UserBinder::class);
});

it('resolves binding', function () {
    $user = User::factory()->create();

    $binder = new UserBinder();

    expect($binder->resolve(User::query(), $user->id, 'edit'))
        ->toBeNull();

    $user = User::factory()->create();

    expect($binder->resolve(User::query(), $user->id, 'edit'))
        ->toBeInstanceOf(User::class);
});

it('resolves binding query', function () {
    $user = User::factory()->create();

    $binder = new UserBinder();

    expect($binder->query(User::query(), $user->id, 'edit'))
        ->toBeInstanceOf(Builder::class);
});
