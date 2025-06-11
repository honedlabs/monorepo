<?php

declare(strict_types=1);

use Honed\Refine\Filters\NumberFilter;
use Honed\Refine\Filters\Filter;

beforeEach(function () {
    $this->filter = NumberFilter::make('price');
});

it('creates', function () {
    expect($this->filter)
        ->getType()->toBe(Filter::NUMBER)
        ->interpretsAs()->toBe('int');
});
