<?php

declare(strict_types=1);

use Honed\Refine\PresenceFilter;

it('has presence filter', function () {
    expect(PresenceFilter::make('status'))
        ->toBeInstanceOf(PresenceFilter::class)
        ->getType()->toBe('boolean')
        ->interpretsAs()->toBe('boolean')
        ->isPresence()->toBeTrue();
});