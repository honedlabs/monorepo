<?php

declare(strict_types=1);

use Honed\Refine\Filters\TextFilter;

beforeEach(function () {
    $this->filter = TextFilter::make('name');
});

it('creates', function () {
    expect($this->filter)
        ->type()->toBe('text')
        ->interpretsAs()->toBe('string');
});
