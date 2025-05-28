<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasIcon;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use Evaluable, HasIcon;
    };
});

it('sets', function () {
    expect($this->test)
        ->getIcon()->toBeNull()
        ->hasIcon()->toBeFalse()
        ->icon('icon')->toBe($this->test)
        ->getIcon()->toBe('icon')
        ->hasIcon()->toBeTrue();
});

it('evaluates', function () {
    $user = User::factory()->create();

    expect($this->test)
        ->icon(fn (User $user) => $user->email)->toBe($this->test)
        ->getIcon(['user' => $user])->toBe($user->email);
});
