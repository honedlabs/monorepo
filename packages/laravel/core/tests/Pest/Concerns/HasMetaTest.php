<?php

use Honed\Core\Tests\Stubs\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set meta', function () {
    $this->component->setMeta($m = [
        'key' => 'value',
    ]);
    expect($this->component->getMeta())->toBe($m);
});

it('can set closure meta', function () {
    $this->component->setMeta(fn () => ['key' => 'value']);
    expect($this->component->getMeta())->toBe([
        'key' => 'value',
    ]);
});

it('prevents null values', function () {
    $this->component->setMeta(['key' => 'value']);
    $this->component->setMeta(null);
    expect($this->component->getMeta())->toEqual(['key' => 'value']);
});

it('can chain meta', function () {
    expect($this->component->meta($m = [
        'key' => 'value',
    ]))->toBeInstanceOf(Component::class);
    expect($this->component->getMeta())->toBe($m);
});

it('checks for meta', function () {
    expect($this->component->hasMeta())->toBeFalse();
    $this->component->setMeta([]);
    expect($this->component->hasMeta())->toBeFalse();
    $this->component->setMeta(['key' => 'value']);
    expect($this->component->hasMeta())->toBeTrue();
});

it('resolves meta', function () {
    expect($this->component->meta(fn ($record) => ['key' => $record.'.']))
        ->toBeInstanceOf(Component::class)
        ->resolveMeta(['record' => 'Meta'])->toEqual(['key' => 'Meta.']);
});
