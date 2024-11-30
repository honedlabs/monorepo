<?php

use Workbench\App\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a string scope', function () {
    $this->component->setScope($n = 'Scope');
    expect($this->component->getScope())->toBe($n);
});

it('can set a closure scope', function () {
    $this->component->setScope(fn () => 'Scope');
    expect($this->component->getScope())->toBe('Scope');
});

it('prevents null values', function () {
    $this->component->setScope(null);
    expect($this->component->missingScope())->toBeTrue();
});

it('can chain scope', function () {
    expect($this->component->scope($n = 'Scope'))->toBeInstanceOf(Component::class);
    expect($this->component->getScope())->toBe($n);
});

it('checks for scope', function () {
    expect($this->component->hasScope())->toBeFalse();
    $this->component->setScope('Scope');
    expect($this->component->hasScope())->toBeTrue();
});

it('checks for no scope', function () {
    expect($this->component->missingScope())->toBeTrue();
    $this->component->setScope('Scope');
    expect($this->component->missingScope())->toBeFalse();
});

it('resolves an scope', function () {
    expect($this->component->scope(fn ($record) => $record.'.'))
        ->toBeInstanceOf(Component::class)
        ->resolveScope(['record' => 'Scope'])->toBe('Scope.');

    expect($this->component->getScope())->toBe('Scope.');
});
