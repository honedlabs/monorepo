<?php

use Workbench\App\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a string format', function () {
    $this->component->setFormat($f = 'd M Y');
    expect($this->component->getFormat())->toBe($f);
});

it('prevents null values', function () {
    $this->component->setFormat(null);
    expect($this->component->missingFormat())->toBeTrue();
});

it('can set a closure format', function () {
    $this->component->setFormat(fn () => 'd M Y');
    expect($this->component->getFormat())->toBe('d M Y');
});

it('can chain format', function () {
    expect($this->component->format($f = 'd M Y'))->toBeInstanceOf(Component::class);
    expect($this->component->getFormat())->toBe($f);
});

it('checks for format', function () {
    expect($this->component->hasFormat())->toBeFalse();
    $this->component->setFormat('d M Y');
    expect($this->component->hasFormat())->toBeTrue();
});

it('checks for no format', function () {
    expect($this->component->missingFormat())->toBeTrue();
    $this->component->setFormat('d M Y');
    expect($this->component->missingFormat())->toBeFalse();
});

it('resolves a format', function () {
    expect($this->component->format(fn ($record) => $record.'.'))
        ->toBeInstanceOf(Component::class)
        ->resolveFormat(['record' => 'Format'])->toBe('Format.');
});
