<?php

declare(strict_types=1);

use Honed\Stats\Overview;
use Honed\Stats\Stat;

beforeEach(function () {
    $this->overview = Overview::make();
});

it('adds stats', function () {
    expect($this->overview)
        ->getStats()->toBeEmpty()
        ->stats([Stat::make('orders')])->toBe($this->overview)
        ->getStats()->toHaveCount(1)
        ->stats(Stat::make('shipping'))->toBe($this->overview)
        ->getStats()->toHaveCount(2)
        ->stats(Stat::make('refunds'), Stat::make('products'))->toBe($this->overview)
        ->getStats()->toHaveCount(4);
});