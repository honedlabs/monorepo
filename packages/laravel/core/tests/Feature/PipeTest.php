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

it('binds the primitive as the first run parameter', function () {
    $component = new Component();

    expect($this->pipe->getParameters($component))
        ->toBe([Component::class => $component]);
});

it('handles instance', function () {
    $component = new Component();

    expect($this->pipe)
        ->handle($component, fn ($component) => $component)->toBeInstanceOf(Component::class);

    expect($component)
        ->getType()->toBe('Pipeline 0');
});
