<?php

use Honed\Core\Concerns\Validatable;
use Honed\Core\Contracts\WithValidator;
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
        ->validator($this->fn)->toBe($this->test)
        ->validate($this->user)->toBeFalse();
});

it('has contract', function () {
    $test = new class() implements WithValidator
    {
        use Validatable;

        public function validateUsing(User $user)
        {
            return $user->id === 1;
        }
    };

    expect($test)
        ->getValidator()->toBeInstanceOf(Closure::class)
        ->validates()->toBeTrue()
        ->validate($this->user)->toBeTrue();
});
