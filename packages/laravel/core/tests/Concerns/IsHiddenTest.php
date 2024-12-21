<?php

use Workbench\App\Component;

it('can set hidden', function () {
    $component = new Component;
    $component->setHidden(true);
    expect($component->isHidden())->toBeTrue();
});

it('prevents null values', function () {
    $component = new Component;
    $component->setHidden(null);
    expect($component->isHidden())->toBeFalse();
});

it('can set closure hidden', function () {
    $component = new Component;
    $component->setHidden(fn () => true);
    expect($component->isHidden())->toBeTrue();
});

it('defaults to false', function () {
    $component = new Component;
    expect($component->isHidden())->toBeFalse();
});

it('can chain hidden', function () {
    $component = new Component;
    expect($component->hidden(true))->toBeInstanceOf(Component::class);
    expect($component->isHidden())->toBeTrue();
});

it('can chain hide', function () {
    $component = new Component;
    expect($component->hide())->toBeInstanceOf(Component::class);
    expect($component->isHidden())->toBeTrue();
});

it('can chain show', function () {
    $component = new Component;
    expect($component->show())->toBeInstanceOf(Component::class);
    expect($component->isHidden())->toBeFalse();
});

it('checks if hidden', function () {
    $component = new Component;
    expect($component->isHidden())->toBeFalse();
    $component->setHidden('Hidden');
    expect($component->isHidden())->toBeTrue();
});

it('checks if not hidden', function () {
    $component = new Component;
    expect($component->IsNotHidden())->toBeTrue();
    $component->setHidden('Hidden');
    expect($component->IsNotHidden())->toBeFalse();
});
