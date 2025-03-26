<?php

declare(strict_types=1);

use Honed\Lock\Facades\Lock;
use Honed\Lock\Locker;
use Honed\Lock\Tests\Stubs\UserPolicy;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;

beforeEach(function () {
    $this->user = user();

    $this->actingAs($this->user);
});

it('has locks', function () {
    expect(Lock::locks())
        ->getLocks()->toBeEmpty()
        ->locks('view')->toBeInstanceOf(Locker::class)
        ->getLocks()->toEqual(['view']);
});

it('has using', function () {
    expect(Lock::uses())->toBeNull();

    expect(Lock::using(['view', 'edit']))
        ->toBeInstanceOf(Locker::class)
        ->uses()->toEqual(['view', 'edit']);
});

it('appends', function () {
    expect(Lock::appendsToModels())->toBeFalse();

    expect(Lock::appendToModels())->toBeInstanceOf(Locker::class)
        ->appendsToModels()->toBeTrue();
});

it('has all', function () {
    expect(Lock::all())
        ->toEqual([
            'view' => true,
            'edit' => false,
        ]);
});

it('has all with inclusions', function () {
    expect(Lock::locks('view'))->toBeInstanceOf(Locker::class)
        ->getLocks()->toEqual(['view'])
        ->all()->toEqual([
            'view' => true,
        ]);
});

it('gets abilities from policy', function () {
    Gate::policy(User::class, UserPolicy::class);

    expect(Lock::fromPolicy(User::class))->toEqual([
        'viewAny',
        'view',
        'create',
        'update',
        'delete',
        'restore',
        'forceDelete',
    ]);
});
