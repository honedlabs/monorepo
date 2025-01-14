<?php

declare(strict_types=1);

use Honed\Core\Option;

it('makes', function () {
    expect(Option::make('value'))->toBeInstanceOf(Option::class)
        ->getValue()->toBe('value')
        ->getLabel()->toBe('Value')
        ->getMeta()->toBe([])
        ->isActive()->toBeFalse();
});

it('has array representation', function () {
    expect(Option::make('value')->toArray())->toEqual([
        'value' => 'value',
        'label' => 'Value',
        'meta' => [],
        'active' => false,
    ]);
});
