<?php

declare(strict_types=1);

use Workbench\App\Classes\Component;
use Workbench\App\Pipes\SetType;

beforeEach(function () {
    $this->pipe = new SetType();
});

afterEach(function () {
    SetType::reset();
});

it('sets instance', function () {
    expect($this->pipe)
        ->getInstance()->toBeNull()
        ->instance(new Component())->toBe($this->pipe)
        ->getInstance()->toBeInstanceOf(Component::class);
});

it('handles instance', function () {
    $component = new Component();

    expect($this->pipe)
        ->handle($component, fn ($component) => $component)->toBeInstanceOf(Component::class);

    expect($component)
        ->getType()->toBe('Pipeline 0');
});

it('calls instance methods', function () {
    $component = new Component();

    expect($this->pipe->instance($component))
        ->getType()->toBeNull();
});
