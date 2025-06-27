<?php

declare(strict_types=1);

use Workbench\App\Classes\Component;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = Component::make();

    $this->user = User::factory()->create();
});

it('sets before callback', function () {
    expect($this->test)
        ->beforeCallback()->toBeNull()
        ->before(fn (User $user) => tap($user, fn (User $user) => $user->update(['name' => 'test']))->save()
        )->toBe($this->test)
        ->beforeCallback()->toBeInstanceOf(Closure::class);

    $this->test->callBefore();

    expect($this->user->refresh())->name->toBe('test');
});

it('sets after callback', function () {
    expect($this->test)
        ->afterCallback()->toBeNull()
        ->after(fn (User $user) => tap($user, fn (User $user) => $user->update(['name' => 'test']))->save()
        )->toBe($this->test)
        ->afterCallback()->toBeInstanceOf(Closure::class);

    $this->test->callAfter();

    expect($this->user->refresh())->name->toBe('test');
});
