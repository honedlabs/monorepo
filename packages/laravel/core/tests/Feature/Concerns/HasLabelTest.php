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

it('makes', function () {
    expect($this->test)
        ->makeLabel(null)->toBeNull()
        ->makeLabel('new-label')->toBe('New label');
});
