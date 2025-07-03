<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanHaveAttributes;
use Honed\Core\Concerns\Evaluable;

beforeEach(function () {
    $this->test = new class()
    {
        use CanHaveAttributes, Evaluable;
    };
});

it('sets', function () {
    expect($this->test)
        ->getAttributes()->toBe([])
        ->attributes(['name' => 'test'])->toBe($this->test)
        ->getAttributes()->toBe(['name' => 'test'])
        ->attributes(['type' => 'test'])->toBe($this->test)
        ->getAttributes()->toBe(['name' => 'test', 'type' => 'test']);
});
