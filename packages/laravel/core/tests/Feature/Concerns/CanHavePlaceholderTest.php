<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanHavePlaceholder;

beforeEach(function () {
    $this->test = new class()
    {
        use CanHavePlaceholder;
    };
});

it('sets', function () {
    expect($this->test)
        ->getPlaceholder()->toBeNull()
        ->placeholder('placeholder')->toBe($this->test)
        ->getPlaceholder()->toBe('placeholder');
});
