<?php

use Honed\Core\Tests\Stubs\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a value', function () {
    $this->component->setValue($v = 'Value');
    expect($this->component->getValue())->toBe($v);
});

it('can set a closure value', function () {
    $this->component->setValue(fn () => false);
    expect($this->component->getValue())->toBeFalse();
});

it('can chain value', function () {
    expect($this->component->value($v = 100))->toBeInstanceOf(Component::class);
    expect($this->component->getValue())->toBe($v);
});

it('resolves a value', function () {
    expect($this->component->value(fn ($record) => $record.'.'))
        ->toBeInstanceOf(Component::class)
        ->resolveValue(['record' => 'Value'])->toBe('Value.');
});
