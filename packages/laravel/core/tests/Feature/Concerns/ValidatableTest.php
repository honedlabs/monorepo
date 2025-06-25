<?php

declare(strict_types=1);

use Honed\Core\Concerns\Validatable;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use Validatable;
    };

    $this->fn = fn (User $user) => $user->id > 100;

    $this->user = User::factory()->create();
});

it('sets', function () {
    expect($this->test)
        ->getValidator()->toBeNull()
        ->validate($this->user)->toBeTrue()
        ->validator(true)->toBe($this->test)
        ->validate($this->user)->toBeTrue()
        ->getValidator()->toBeTrue();
});

it('evaluates', function () {
    expect($this->test)
        ->validate($this->user)->toBeTrue()
        ->isValid($this->user)->toBeTrue()
        ->validator($this->fn)->toBe($this->test)
        ->validate($this->user)->toBeFalse()
        ->isValid($this->user)->toBeFalse();
});
