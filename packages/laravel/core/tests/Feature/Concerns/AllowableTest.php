<?php

declare(strict_types=1);

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\Evaluable;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use Allowable, Evaluable;
    };

    $this->user = User::factory()->create();
});

it('sets', function () {
    expect($this->test)
        ->isAllowed()->toBeTrue()
        ->allow(false)->toBe($this->test)
        ->isAllowed()->toBeFalse();
});

it('evaluates', function () {
    expect($this->test)
        ->allow(fn (User $user) => $user->id > 100)
        ->isAllowed(['user' => $this->user])->toBeFalse();
});
