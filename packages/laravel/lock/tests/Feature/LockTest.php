<?php

declare(strict_types=1);

use Honed\Lock\Facades\Lock;
use Honed\Lock\Locker;
use Honed\Lock\Tests\Stubs\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->actingAs($this->user);
});

it('sets abilities', function () {
    expect(Lock::abilities())
        ->getAbilities()->toBeEmpty()
        ->abilities('view')->toBeInstanceOf(Locker::class)
        ->getAbilities()->toEqual(['view'])
        ->ability('edit')->toBeInstanceOf(Locker::class)
        ->getAbilities()->toEqual(['view', 'edit']);
});

it('sets using', function () {
    expect(Lock::uses())->toBeNull();

    expect(Lock::using(['view', 'edit']))
        ->toBeInstanceOf(Locker::class)
        ->uses()->toEqual(['view', 'edit']);
});

it('appends', function () {
    expect(Lock::appendsLocks())->toBeFalse();

    Lock::shouldAppend();

    expect(Lock::appendsLocks())->toBeTrue();
});

it('has all', function () {
    expect(Lock::all())
        ->toEqual([
            'view' => true,
            'edit' => false,
        ]);
});

it('has all with inclusions', function () {
    expect(Lock::abilities('view'))->toBeInstanceOf(Locker::class)
        ->getAbilities()->toEqual(['view'])
        ->all()->toEqual([
            'view' => true,
        ]);
});

// it('gets abilities from policy', function () {
//     Gate::policy(User::class, UserPolicy::class);

//     expect(Lock::abilitiesFromPolicy(User::class))->toEqual([
//         'viewAny',
//         'view',
//         'create',
//         'update',
//         'delete',
//         'restore',
//         'forceDelete',
//     ]);
// });
