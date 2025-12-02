<?php

declare(strict_types=1);

use Honed\Infolist\Entries\CurrencyEntry;

beforeEach(function () {
    $this->entry = CurrencyEntry::make('price')
        ->currency(fn ($record) => $record ? $record['currency'] : null);
});

it('scopes formatter', function () {
    expect($this->entry)
        ->getCurrency()->toBeNull()
        ->record(['currency' => 'usd'])->toBe($this->entry)
        ->getCurrency()->toBe('USD')
        ->getFormatter()
        ->scoped(fn ($formatter) => $formatter
            ->getCurrency()->toBeNull()
        )
        ->getScopedFormatter()
        ->scoped(fn ($formatter) => $formatter
            ->getCurrency()->toBe('USD')
        )
        ->format(100)->toBe('$100.00');
});
