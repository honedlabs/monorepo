<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanHaveAttributes;
use Honed\Core\Concerns\Evaluable;

beforeEach(function () {
    $this->test = new class()
    {
        use CanHaveAttributes, Evaluable;
    };
});

it('sets with arrays', function () {
    expect($this->test)
        ->getAttributes()->toBe([])
        ->attributes(['name' => 'test'])->toBe($this->test)
        ->getAttributes()->toBe(['name' => 'test'])
        ->attributes(['type' => 'test'])->toBe($this->test)
        ->getAttributes()->toBe(['name' => 'test', 'type' => 'test']);
});

it('sets with key and value', function () {
    expect($this->test)
        ->getAttributes()->toBe([])
        ->attributes('name', 'test')->toBe($this->test)
        ->getAttributes()->toBe(['name' => 'test']);
});

it('sets attributes', function () {
    expect($this->test)
        ->getAttributes()->toBe([])
        ->attribute('name', 'test')->toBe($this->test)
        ->getAttributes()->toBe(['name' => 'test']);
});
