<?php

declare(strict_types=1);

use Honed\Refine\DescSort;

it('has desc sort', function () {
    expect(DescSort::make('created_at'))
        ->toBeInstanceOf(DescSort::class)
        ->isFixed()->toBeTrue()
        ->getDirection()->toBe('desc')
        ->getType()->toBe('desc');
});