<?php

declare(strict_types=1);

use Honed\Core\Concerns\IsDefault;


beforeEach(function () {
    $this->test = new class {
        use IsDefault;
    };
});

it('accesses', function () {
    expect($this->test)
        ->isDefault()->toBeFalse()
        ->default()->toBe($this->test)
        ->isDefault()->toBeTrue();
});