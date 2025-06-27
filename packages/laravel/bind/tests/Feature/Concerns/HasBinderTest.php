<?php

declare(strict_types=1);

use App\Binders\AdminBinder;
use App\Binders\UserBinder;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

beforeEach(function () {
    $this->artisan('bind:cache')->assertSuccessful();

    $this->user = User::factory()->create();
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
    expect((new User())->resolveRouteBinding($this->user->id))
        ->toBeInstanceOf(User::class)
        ->getAttributes()->toEqual([
            'id' => $this->user->id,
            'name' => $this->user->name,
        ]);
});

it('uses key route model binding', function () {
    expect((new User())->resolveRouteBinding($this->user->id, 'auth'))
        ->toBeInstanceOf(User::class)
        ->getAttributes()->toEqual([
            'email' => $this->user->email,
        ]);
});

it('uses custom route model binding', function () {
    expect((new User())->resolveRouteBinding($this->user->name, 'admin'))
        ->toBeInstanceOf(User::class)
        ->getAttributes()->scoped(fn ($attributes) => $attributes
        ->toBeArray()
        ->{'id'}->toBe($this->user->id)
        ->{'name'}->toBe($this->user->name));
});

it('still allows regular route model binding', function () {
    expect((new User())->resolveRouteBinding($this->user->id, 'id'))
        ->toBeInstanceOf(User::class)
        ->getAttributes()->scoped(fn ($attributes) => $attributes
        ->toBeArray()
        ->{'id'}->toBe($this->user->id)
        ->{'name'}->toBe($this->user->name));
});

it('gets first model', function () {
    expect(User::firstBound(value: $this->user->id))
        ->toBeInstanceOf(User::class)
        ->getAttributes()->toEqual([
            'id' => $this->user->id,
            'name' => $this->user->name,
        ]);

    expect(User::firstBound('false', $this->user->id))
        ->toBeNull();
});

it('gets models', function () {
    expect(User::getBound(value: $this->user->id))
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->scoped(fn ($user) => $user
        ->getAttributes()->toEqual([
            'id' => $this->user->id,
            'name' => $this->user->name,
        ])
        );

    expect(User::getBound('false', $this->user->id))
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1);
});

it('scopes query', function () {
    expect(User::whereBound('edit', $this->user->id))
        ->toBeInstanceOf(Builder::class)
        ->get()->scoped(fn ($users) => $users
        ->toBeInstanceOf(Collection::class)
        ->toBeEmpty()
        );

    expect(User::whereBound('false', $this->user->id))
        ->toBeInstanceOf(Builder::class)
        ->get()->scoped(fn ($users) => $users
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        );
});
