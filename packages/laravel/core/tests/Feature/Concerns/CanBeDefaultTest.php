<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanBeDefault;

beforeEach(function () {
    $this->test = new class()
    {
        use CanBeDefault;
    };
});

it('sets', function () {
    expect($this->test)
        ->isNotDefault()->toBeTrue()
        ->isDefault()->toBeFalse()
        ->default()->toBe($this->test)
        ->isDefault()->toBeTrue()
        ->notDefault()->toBe($this->test)
        ->isNotDefault()->toBeTrue();
});
