<?php

use Honed\Core\Contracts\WithoutNullValues;
use Workbench\App\Classes\Component;

beforeEach(function () {
    $this->test = Component::make();
});

it('makes', function () {
    expect(Component::make())->toBeInstanceOf(Component::class)
        ->getType()->toBe('component')
        ->getName()->toBe('Products');
});

it('has array representation', function () {
    expect($this->test)
        ->toArray()->toEqual([
        'type' => 'component',
        'name' => 'Products',
        'meta' => null,
    ]);
});

it('serializes', function () {
    expect($this->test)
        ->jsonSerialize()->toEqual($this->test->toArray());
});

it('serializes without null values', function () {
    $test = new class extends Component implements WithoutNullValues { };

    expect($test)
        ->jsonSerialize()->toEqual([
        'type' => 'component',
        'name' => 'Products',
    ]);
});

it('is macroable', function () {
    $this->test->macro('test', function () {
        return 'test';
    });

    expect($this->test)
        ->test()->toBe('test');
});
