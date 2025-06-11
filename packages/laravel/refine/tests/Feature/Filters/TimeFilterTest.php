<?php

declare(strict_types=1);

use Honed\Refine\Filters\TimeFilter;

beforeEach(function () {
    $this->filter = TimeFilter::make('time');
});

it('creates', function () {
    expect($this->filter)
        ->type()->toBe('time')
        ->interpretsAs()->toBe('time');
});
