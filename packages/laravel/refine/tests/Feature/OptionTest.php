<?php

declare(strict_types=1);

use Honed\Refine\Option;

beforeEach(function () {
    $this->option = Option::make('test', 'Test');
});

it('creates', function () {
    expect($this->option)
        ->toBe($this->option)
        ->getValue()->toBe('test')
        ->getLabel()->toBe('Test');
});

it('activates an option', function () {
    $option = Option::make(10);

    expect($option)
        ->activate(10)->toBeTrue()
        ->isActive()->toBeTrue();

    expect($option)
        ->activate(5)->toBeFalse()
        ->isActive()->toBeFalse();
});

it('has array representation', function () {
    expect($this->option)
        ->toArray()->toEqual([
            'value' => 'test',
            'label' => 'Test',
            'active' => false,
        ]);
});

it('serializes', function () {
    expect($this->option)
        ->jsonSerialize()->toEqual($this->option->toArray());
});
