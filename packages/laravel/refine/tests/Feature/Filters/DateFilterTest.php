<?php

declare(strict_types=1);

use Honed\Refine\Filters\DateFilter;

beforeEach(function () {
    $this->filter = DateFilter::make('created_at');
});

it('creates', function () {
    expect($this->filter)
        ->type()->toBe('date')
        ->interpretsAs()->toBe('date');
});
