<?php

use Workbench\App\Classes\Component;

beforeEach(function () {
    $this->test = Component::make();
});

it('makes', function () {
    expect(Component::make())->toBeInstanceOf(Component::class)
        ->getType()->toBe('Component')
        ->getName()->toBe('Products');
});

it('has array representation', function () {
    expect($this->test)
        ->toArray()->toEqual([
        'type' => 'Component',
        'name' => 'Products',
        'meta' => [],
    ]);
});

it('serializes', function () {
    expect($this->test)
        ->jsonSerialize()->toEqual($this->test->toArray());
});

it('is macroable', function () {
    $this->test->macro('test', function () {
        return 'test';
    });

    expect($this->test)
        ->test()->toBe('test');
});
