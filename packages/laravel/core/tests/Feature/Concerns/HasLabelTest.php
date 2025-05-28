<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasLabel;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use Evaluable, HasLabel;
    };

    $this->user = User::factory()->create();
});

it('sets', function () {
    expect($this->test)
        ->getLabel()->toBeNull()
        ->hasLabel()->toBeFalse()
        ->label('label')->toBe($this->test)
        ->getLabel()->toBe('label')
        ->hasLabel()->toBeTrue();
});

it('evaluates', function () {
    expect($this->test)
        ->label(fn (User $user) => $user->email)->toBe($this->test)
        ->getLabel(['user' => $this->user])->toBe($this->user->email);
});

it('makes', function () {
    expect($this->test)
        ->makeLabel(null)->toBeNull()
        ->makeLabel('new-label')->toBe('New label');
});
