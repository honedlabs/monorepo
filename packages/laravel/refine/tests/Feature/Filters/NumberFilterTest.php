<?php

declare(strict_types=1);

use Honed\Refine\Filters\NumberFilter;

beforeEach(function () {
    $this->filter = NumberFilter::make('price');
});

it('creates', function () {
    expect($this->filter)
        ->type()->toBe('number')
        ->interpretsAs()->toBe('int');
});
