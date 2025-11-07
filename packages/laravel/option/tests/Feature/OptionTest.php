<?php

declare(strict_types=1);

use Honed\Option\Option;

beforeEach(function () {});

it('makes option', function () {
    expect(Option::make(1, 'One'))
        ->toBeInstanceOf(Option::class)
        ->getValue()->toBe(1)
        ->getLabel()->toBe('One');
});

it('has array representation', function () {
    expect(Option::make(1, 'One'))
        ->toArray()->toBe([
            'value' => 1,
            'label' => 'One',
        ]);
});
