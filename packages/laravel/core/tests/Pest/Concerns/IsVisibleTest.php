<?php

use Honed\Core\Tests\Stubs\Component;

it('can set visible', function () {
    $component = new Component;
    $component->setVisible(true);
    expect($component->isVisible())->toBeTrue();
});

it('rejects null values', function () {
    $component = new Component;
    $component->setVisible(null);
    expect($component->isVisible())->toBeTrue();
});

it('defaults to true', function () {
    $component = new Component;
    expect($component->isVisible())->toBeTrue();
});

it('can chain visible', function () {
    $component = new Component;
    expect($component->visible(true))->toBeInstanceOf(Component::class);
    expect($component->isVisible())->toBeTrue();
});

it('can chain invisible', function () {
    $component = new Component;
    expect($component->invisible())->toBeInstanceOf(Component::class);
    expect($component->isVisible())->toBeFalse();
});

it('checks if visible', function () {
    $component = new Component;
    expect($component->isVisible())->toBeTrue();
    $component->setVisible(false);
    expect($component->isVisible())->toBeFalse();
});