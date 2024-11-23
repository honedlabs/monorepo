<?php

use Workbench\App\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a string label', function () {
    $this->component->setLabel($l = 'Label');
    expect($this->component->getLabel())->toBe($l);
});

it('can set a closure label', function () {
    $this->component->setLabel(fn () => 'Label');
    expect($this->component->getLabel())->toBe('Label');
});

it('prevents null values', function () {
    $this->component->setLabel(null);
    expect($this->component->missingLabel())->toBeTrue();
});

it('can chain label', function () {
    expect($this->component->label($l = 'Label'))->toBeInstanceOf(Component::class);
    expect($this->component->getLabel())->toBe($l);
});

it('checks for label', function () {
    expect($this->component->hasLabel())->toBeFalse();
    $this->component->setLabel('Label');
    expect($this->component->hasLabel())->toBeTrue();
});

it('checks for no label', function () {
    expect($this->component->missingLabel())->toBeTrue();
    $this->component->setLabel('Label');
    expect($this->component->missingLabel())->toBeFalse();
});

it('converts text to a label', function () {
    $label = $this->component->makeLabel('new-Label');
    expect($label)->toBe('New label');
});

it('resolves a label', function () {
    expect($this->component->label(fn ($record) => $record.'.'))
        ->toBeInstanceOf(Component::class)
        ->resolveLabel(['record' => 'Label'])->toBe('Label.');
});
