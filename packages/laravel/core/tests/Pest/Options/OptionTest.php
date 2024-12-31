<?php

use Honed\Core\Options\Option;
use Honed\Core\Tests\Stubs\Status;
use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Tests\Stubs\Component;

it('can instantiate', function () {
    expect(new Option(1))->toBeInstanceOf(Option::class)
        ->getValue()->toBe(1)
        ->getLabel()->toBe('1')
        ->getMeta()->toBe([])
        ->isActive()->toBeFalse();
});

it('is makeable', function () {
    expect(Option::make('value'))->toBeInstanceOf(Option::class)
        ->getValue()->toBe('value')
        ->getLabel()->toBe('Value')
        ->getMeta()->toBe([])
        ->isActive()->toBeFalse();
});

it('can chain a value', function () {
    expect(Option::make('value')->value(1))->toBeInstanceOf(Option::class)
        ->getValue()->toBe(1);
});

it('can chain a label', function () {
    expect(Option::make('value')->label('New Value'))->toBeInstanceOf(Option::class)
        ->getLabel()->toBe('New Value');
});

it('can chain meta', function () {
    expect(Option::make('value')->meta(['key' => 'value']))->toBeInstanceOf(Option::class)
        ->getMeta()->toBe(['key' => 'value']);
});

it('can chain active', function () {
    expect(Option::make('value')->active(true))->toBeInstanceOf(Option::class)
        ->isActive()->toBeTrue();
});

it('has array representation', function () {
    expect(Option::make('value')->toArray())->toEqual([
        'value' => 'value',
        'label' => 'Value',
        'meta' => [],
        'active' => false,
    ]);
});
