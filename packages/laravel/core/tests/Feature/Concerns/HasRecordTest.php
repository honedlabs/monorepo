<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasRecord;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use HasRecord;
    };
});

it('sets', function () {
    $user = User::factory()->create();

    expect($this->test)
        ->getRecord()->toBeNull()
        ->record($user)->toBe($this->test)
        ->getRecord()->toBe($user);
});
