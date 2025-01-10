<?php

use Honed\Core\Option;

it('makes', function () {
    expect(Option::make('value'))->toBeInstanceOf(Option::class)
        ->value()->toBe('value')
        ->label()->toBe('Value')
        ->meta()->toBe([])
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
