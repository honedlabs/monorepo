<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasName;

beforeEach(function () {
    $this->test = new class()
    {
        use HasName;
    };
});

it('sets', function () {
    expect($this->test)
        ->name('name')->toBe($this->test)
        ->getName()->toBe('name');
});
