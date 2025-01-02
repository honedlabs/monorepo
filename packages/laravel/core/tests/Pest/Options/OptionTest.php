<?php

use Honed\Core\Options\Option;


it('can instantiate', function () {
    expect(new Option(1))->toBeInstanceOf(Option::class)
        ->getValue()->toBe(1)
        ->getLabel()->toBe((string) 1)
        ->getMeta()->toBe([])
        ->isActive()->toBeFalse();
});

it('can be made', function () {
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
