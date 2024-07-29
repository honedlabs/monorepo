<?php

use Workbench\App\Component;

it('can set a value', function () {
    $component = new Component();
    $component->setValue($v = 'Value');
    expect($component->getValue())->toBe($v);
});

it('can set a closure value', function () {
    $component = new Component();
    $component->setValue(fn () => false);
    expect($component->getValue())->toBeFalse();
});

it('can chain value', function () {
    $component = new Component();
    expect($component->value($v = 100))->toBeInstanceOf(Component::class);
    expect($component->getValue())->toBe($v);
});
