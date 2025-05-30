<?php

declare(strict_types=1);

use Honed\Lock\Facades\Lock;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Workbench\App\Models\Product;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->product = Product::factory()->create();
    Lock::shouldAppend(false);
});

it('initializes', function () {
    expect($this->user)
        ->isLocking()->toBeFalse()
        ->isNotLocking()->toBeTrue()
        ->isntLocking()->toBeTrue()
        ->withLocks()->toBe($this->user)
        ->isLocking()->toBeTrue()
        ->isNotLocking()->toBeFalse()
        ->isntLocking()->toBeFalse()
        ->withoutLocks()->toBe($this->user)
        ->isLocking()->toBeFalse()
        ->isNotLocking()->toBeTrue()
        ->isntLocking()->toBeTrue();

    Lock::shouldAppend(true);

    expect(User::factory()->create())
        ->isLocking()->toBeTrue();
});

it('has locks', function () {
    expect($this->user)
        ->locks()->toBe($this->user);
});

it('has lock attribute', function () {
    expect($this->user)
        ->lock()->toBeInstanceOf(Attribute::class);
});

it('gets locks via policy', function () {
    expect($this->user->getLocks())
        ->toBeArray()
        ->toHaveCount(6)
        ->toHaveKeys([
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
        ]);
});

it('gets locks via array', function () {
    expect($this->product->getLocks())
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys([
            'view',
            'update',
        ]);
});
