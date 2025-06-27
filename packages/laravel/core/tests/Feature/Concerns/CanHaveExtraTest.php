<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanHaveExtra;
use Honed\Core\Concerns\Evaluable;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class()
    {
        use CanHaveExtra, Evaluable;
    };

    $this->user = User::factory()->create();
});

it('sets', function () {
    expect($this->test)
        ->getExtra()->toBeNull()
        ->hasExtra()->toBeFalse()
        ->extra(['key' => 'value'])->toBe($this->test)
        ->getExtra()->toEqual(['key' => 'value'])
        ->hasExtra()->toBeTrue();
});
