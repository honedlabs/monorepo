<?php

declare(strict_types=1);

use Honed\Refine\TextFilter;

it('has text filter', function () {
    expect(TextFilter::make('name'))
        ->toBeInstanceOf(TextFilter::class)
        ->getOperator()->toBe('LIKE')
        ->getType()->toBe('text')
        ->interpretsAs()->toBe('string');
});