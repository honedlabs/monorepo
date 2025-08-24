<?php

declare(strict_types=1);

use App\Models\User;
use Honed\Widget\Concerns\Resolvable;

beforeEach(function () {
    $this->class = new class {
        use Resolvable;
    };
});

it('resolves scopes', function () {
    $user = User::factory()->create();

    expect($this->class->resolveScope($user))->toBe(User::class.'|'.$user->getKey());
});

it('resolves widgets', function () {
    expect($this->class->resolveWidget('user-count'))->toBe('user-count');
});