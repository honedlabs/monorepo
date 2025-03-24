<?php

declare(strict_types=1);

use Honed\Lock\Facades\Lock;
use Honed\Lock\Locker;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;

beforeEach(function () {
    $this->user = user();

    $this->actingAs($this->user);
    
    Gate::define('view', function ($user) {
        return $user->id === 1;
    });

    Gate::define('edit', function ($user) {
        return $user->id === 2;
    });
});

it('generates locks', function () {
    expect(Lock::generateLocks())
        ->toEqual([
            'view' => true,
            'edit' => false,
        ]);
});

it('generates selected locks', function () {
    expect(Lock::locks('view'))->toBeInstanceOf(Locker::class)
        ->getLocks()->toEqual(['view'])
        ->generateLocks()->toEqual([
            'view' => true,
        ]);
});

it('gets abilities from policy', function () {
    $this->artisan('make:policy', [
        'name' => 'UserPolicy',
        '--force' => true,
        '--model' => User::class,
    ])->assertSuccessful();

    expect(Lock::getAbilitiesFromPolicy(User::class))->dd();
});

