<?php

declare(strict_types=1);

use Honed\Refine\Option;

beforeEach(function () {
    $this->value = 'test';
    $this->label = 'Test';
    $this->option = Option::make($this->value, $this->label);
});

it('creates', function () {
    expect($this->option)
        ->toBe($this->option)
        ->getValue()->toBe($this->value)
        ->getLabel()->toBe($this->label);
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
            'value' => $this->value,
            'label' => $this->label,
            'active' => false,
        ]);
});

it('serializes', function () {
    expect($this->option)
        ->jsonSerialize()->toEqual($this->option->toArray());
});
