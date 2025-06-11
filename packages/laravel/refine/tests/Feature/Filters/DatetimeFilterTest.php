<?php

declare(strict_types=1);

use Honed\Refine\Filters\DatetimeFilter;

beforeEach(function () {
    $this->filter = DatetimeFilter::make('datetime');
});

it('creates', function () {
    expect($this->filter)
        ->type()->toBe('datetime')
        ->interpretsAs()->toBe('datetime');
});
