<?php

declare(strict_types=1);

use Honed\Lock\Facades\Lock;
use Honed\Lock\Locker;
use Honed\Lock\Tests\Stubs\Product;
use Honed\Lock\Tests\Stubs\UserPolicy;
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
    Gate::policy(User::class, UserPolicy::class);

    expect(Lock::getAbilitiesFromPolicy(User::class))->toEqual([
        'viewAny',
        'view',
        'create',
        'update',
        'delete',
        'restore',
        'forceDelete',
    ]);
});

it('get abilities from no policy', function () {
    expect(Lock::getAbilitiesFromPolicy(Product::class))->toEqual([]);
});

it('includes locks', function () {
    expect(Lock::includesLocks())->toBeFalse();
    
    expect(Lock::includeLocks())->toBeInstanceOf(Locker::class)
        ->includesLocks()->toBeTrue();
});
