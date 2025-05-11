<?php

declare(strict_types=1);

use Honed\Chart\Concerns\FiltersUndefined;

beforeEach(function () {
    $this->class = new class {
        use FiltersUndefined;
    };
});

it('filters undefined values', function () {
    expect($this->class->filterUndefined([
        'a' => 1,
        'b' => null,
        'c' => 3,
    ]))->toEqual([
        'a' => 1,
        'c' => 3,
    ]);
});

