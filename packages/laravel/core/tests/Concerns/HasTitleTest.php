<?php

use Workbench\App\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can set a string title', function () {
    $this->component->setTitle($t = 'Title');
    expect($this->component->getTitle())->toBe($t);
});

it('can set a closure title', function () {
    $this->component->setTitle(fn () => 'Title');
    expect($this->component->getTitle())->toBe('Title');
});

it('prevents null values', function () {
    $this->component->setTitle(null);
    expect($this->component->missingTitle())->toBeTrue();
});

it('can chain title', function () {
    expect($this->component->title($t = 'Title'))->toBeInstanceOf(Component::class);
    expect($this->component->getTitle())->toBe($t);
});

it('checks for title', function () {
    expect($this->component->hasTitle())->toBeFalse();
    $this->component->setTitle('Title');
    expect($this->component->hasTitle())->toBeTrue();
});

it('checks for no title', function () {
    expect($this->component->missingTitle())->toBeTrue();
    $this->component->setTitle('Title');
    expect($this->component->missingTitle())->toBeFalse();
});

it('resolves a title', function () {
    expect($this->component->title(fn ($record) => $record.'.'))
        ->toBeInstanceOf(Component::class)
        ->resolveTitle(['record' => 'Title'])->toBe('Title.');
});
