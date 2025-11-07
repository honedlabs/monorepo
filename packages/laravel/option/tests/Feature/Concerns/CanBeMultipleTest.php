<?php

declare(strict_types=1);

use Honed\Option\Concerns\CanBeMultiple;

beforeEach(function () {
    $this->class = new class()
    {
        use CanBeMultiple;
    };
});

it('can be multiple', function () {
    expect($this->class)
        ->isMultiple()->toBeFalse()
        ->isNotMultiple()->toBeTrue()
        ->multiple()->toBe($this->class)
        ->isMultiple()->toBeTrue()
        ->isNotMultiple()->toBeFalse()
        ->notMultiple()->toBe($this->class)
        ->isMultiple()->toBeFalse()
        ->isNotMultiple()->toBeTrue();
});
