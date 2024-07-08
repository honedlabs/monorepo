<?php

use Conquest\Core\Options\Option;

it('can create an option', function () {
    $option = new Option(1);
    expect($option->getValue())->toBe(1);
    expect($option->getLabel())->toBe('1');
    expect($option->toArray())->toBe([
        'value' => 1,
        'label' => '1',
        'metadata' => [],
        'active' => false,
    ]);
});

it('can make an option', function () {
    expect($option = Option::make($v = 'value'))->toBeInstanceOf(Option::class);
    expect($option->getValue())->toBe($v);
    expect($option->getLabel())->toBe($l = 'Value');
    expect($option->toArray())->toBe([
        'value' => $v,
        'label' => $l,
        'metadata' => [],
        'active' => false,
    ]);
});

it('can set a value', function () {
    expect($option = Option::make('value')->value(1))->toBeInstanceOf(Option::class);
    expect($option->getValue())->toBe(1);
});

it('can set a label', function () {
    expect($option = Option::make('value')->label('New Value'))->toBeInstanceOf(Option::class);
    expect($option->getLabel())->toBe('New Value');
});

it('can set metadata', function () {
    expect($option = Option::make('value')->metadata($m = ['key' => 'value']))->toBeInstanceOf(Option::class);
    expect($option->getMetadata())->toBe($m);
});

it('can set active', function () {
    $option = new Option('value');
    $option->setActive(true);
    expect($option->isActive())->toBeTrue();
});