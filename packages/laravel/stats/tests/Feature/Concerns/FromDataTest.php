<?php

declare(strict_types=1);

use Honed\Stats\Stat;

beforeEach(function () {
    $this->stat = Stat::make('name');
})->skip();

it('has data', function () {
    expect($this->stat)
        ->why()->toBeNull()
        ->from('test')->toBe($this->stat)
        ->why()->toBe('test')
        ->from(fn () => 'callable')->toBe($this->stat)
        ->why()->toBe('callable');
});
