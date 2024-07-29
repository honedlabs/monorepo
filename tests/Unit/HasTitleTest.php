<?php

use Workbench\App\Component;

it('can set a string title', function () {
    $component = new Component();
    $component->setTitle($t = 'Title');
    expect($component->getTitle())->toBe($t);
});

it('can set a closure title', function () {
    $component = new Component();
    $component->setTitle(fn () => 'Title');
    expect($component->getTitle())->toBe('Title');
});

it('prevents null values', function () {
    $component = new Component();
    $component->setTitle(null);
    expect($component->lacksTitle())->toBeTrue();
});


it('can chain title', function () {
    $component = new Component();
    expect($component->title($t = 'Title'))->toBeInstanceOf(Component::class);
    expect($component->getTitle())->toBe($t);
});

it('checks for title', function () {
    $component = new Component();
    expect($component->hasTitle())->toBeFalse();
    $component->setTitle('Title');
    expect($component->hasTitle())->toBeTrue();
});

it('checks for no title', function () {
    $component = new Component();
    expect($component->lacksTitle())->toBeTrue();
    $component->setTitle('Title');
    expect($component->lacksTitle())->toBeFalse();
});
