<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasName;

beforeEach(function () {
    $this->test = new class {
        use HasName;
    };

    $this->param = 'name';
});

it('accesses', function () {
    expect($this->test)
        ->getName()->toBeNull()
        ->name($this->param)->toBe($this->test)
        ->getName()->toBe($this->param);
});