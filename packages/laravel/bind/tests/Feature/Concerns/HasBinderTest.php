<?php

use App\Models\User;
use Honed\Bind\Binder;
use App\Binders\UserBinder;
use App\Binders\AdminBinder;

beforeEach(function () {
    $this->artisan('bind:cache')->assertSuccessful();
});

it('retrieves binder', function () {
    expect(User::binder('default'))
        ->toBeInstanceOf(UserBinder::class);

    expect(User::binder('admin'))
        ->toBeInstanceOf(AdminBinder::class);
    
    expect(User::binder('show'))
        ->toBeNull();
});

it('uses default route model binding', function () {
    $user = User::factory()->create();

    expect((new User())->resolveRouteBinding($user->id))
        ->toBeInstanceOf(User::class)
        ->getAttributes()->toEqual([
            'id' => $user->id,
            'name' => $user->name,
        ]);
});

it('uses key route model binding', function () {
    $user = User::factory()->create();

    expect((new User())->resolveRouteBinding($user->id, 'auth'))
        ->toBeInstanceOf(User::class)
        ->getAttributes()->toEqual([
            'email' => $user->email,
        ]);
});

it('uses custom route model binding', function () {
    $user = User::factory()->create();

    expect((new User())->resolveRouteBinding($user->name, 'admin'))
        ->toBeInstanceOf(User::class)
        ->getAttributes()->scoped(fn ($attributes) => $attributes
            ->toBeArray()
            ->{'id'}->toBe($user->id)
            ->{'name'}->toBe($user->name));
});

it('still allows regular route model binding', function () {
    $user = User::factory()->create();

    expect((new User())->resolveRouteBinding($user->id, 'id'))
        ->toBeInstanceOf(User::class)
        ->getAttributes()->scoped(fn ($attributes) => $attributes
            ->toBeArray()
            ->{'id'}->toBe($user->id)
            ->{'name'}->toBe($user->name));
});

// it('allows for first queries', function () {
//     $user = User::factory()->create();

//     expect()
// });