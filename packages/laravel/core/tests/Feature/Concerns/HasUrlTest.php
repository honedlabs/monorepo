<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasUrl;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use Evaluable, HasUrl;
    };

    $this->user = User::factory()->create();
});

it('sets route', function () {
    expect($this->test)
        ->getUrl()->toBeNull()
        ->hasUrl()->toBeFalse()
        ->url('users.show', $this->user)->toBe($this->test)
        ->getUrl()->toBe(route('users.show', $this->user))
        ->hasUrl()->toBeTrue();
});

it('sets closure', function () {
    expect($this->test)
        ->url(fn (User $user) => url('users.show', $user))->toBe($this->test)
        ->getUrl(['user' => $this->user])->toBe(url('users.show', $this->user));
});

it('sets implicit route url', function () {
    expect($this->test)
        // Will always be bound as model
        ->url('users.show', '{record}')->toBe($this->test)
        ->getUrl(['record' => $this->user])->toBe(route('users.show', $this->user));
});

it('sets uri', function () {
    expect($this->test)
        ->getUrl()->toBeNull()
        ->url('/users')->toBe($this->test)
        ->getUrl()->toBe(url('/users'));
});

it('sets url', function () {
    expect($this->test)
        ->getUrl()->toBeNull()
        ->url('https://example.com')->toBe($this->test)
        ->getUrl()->toBe('https://example.com');
});

it('sets to same page', function () {
    expect($this->test)
        ->url('#')->toBe($this->test)
        ->getUrl()->toBe(url('#'));
});
