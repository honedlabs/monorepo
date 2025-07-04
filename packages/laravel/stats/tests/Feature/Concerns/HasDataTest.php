<?php

declare(strict_types=1);

use Honed\Stats\Stat;

beforeEach(function () {
    $this->stat = Stat::make('name');
});

it('has data', function () {
    expect($this->stat)
        ->getData()->toBeNull()
        ->data('test')->toBe($this->stat)
        ->getData()->toBe('test')
        ->data(fn () => 'callable')->toBe($this->stat)
        ->getData()->toBe('callable');
});
