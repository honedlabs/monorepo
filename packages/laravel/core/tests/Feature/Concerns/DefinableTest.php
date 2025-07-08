<?php

declare(strict_types=1);

use Honed\Core\Concerns\Definable;
use Honed\Core\Concerns\HasType;

beforeEach(function () {
    $this->test = new class()
    {
        use Definable, HasType;

        protected function definition(): static
        {
            return $this->type('test');
        }
    };
});

it('defines the instance', function () {
    expect($this->test)
        ->getType()->toBeNull()
        ->define()->toBeNull()
        ->getType()->toBe('test');
});
