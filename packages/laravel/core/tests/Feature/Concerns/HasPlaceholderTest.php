<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasPlaceholder;

beforeEach(function () {
    $this->test = new class()
    {
        use HasPlaceholder;
    };
});

it('sets', function () {
    expect($this->test)
        ->getPlaceholder()->toBeNull()
        ->hasPlaceholder()->toBeFalse()
        ->missingPlaceholder()->toBeTrue()
        ->placeholder('placeholder')->toBe($this->test)
        ->hasPlaceholder()->toBeTrue()
        ->missingPlaceholder()->toBeFalse()
        ->getPlaceholder()->toBe('placeholder');
});
