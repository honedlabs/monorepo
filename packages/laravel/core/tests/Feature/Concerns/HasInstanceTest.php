<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasInstance;
use Workbench\App\Classes\Component;

beforeEach(function () {
    $this->test = new class() {
        use HasInstance;
    };

    $this->component = Component::make();
});

it('sets instance', function () {
    expect($this->test)
        ->getInstance()->toBeNull()
        ->instance($this->component)->toBe($this->test)
        ->getInstance()->toBeInstanceOf(Component::class);
});

it('calls instance methods', function () {
    expect($this->test->instance($this->component))
        ->getType()->toBe('component');
});