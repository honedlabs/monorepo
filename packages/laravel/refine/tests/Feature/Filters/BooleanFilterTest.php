<?php

declare(strict_types=1);

use Honed\Refine\Filters\BooleanFilter;

beforeEach(function () {
    $this->filter = BooleanFilter::make('is_active');
});

it('creates', function () {
    expect($this->filter)
        ->type()->toBe('boolean')
        ->interpretsAs()->toBe('boolean');
});
