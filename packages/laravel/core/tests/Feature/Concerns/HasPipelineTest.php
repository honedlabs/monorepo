<?php

declare(strict_types=1);

use Workbench\App\Classes\Component;
use Workbench\App\Pipes\SetName;

beforeEach(function () {
    $this->component = Component::make();
});

afterEach(function () {
    SetName::reset();
});

it('can be completed', function () {
    expect($this->component)
        ->isNotCompleted()->toBeTrue()
        ->isCompleted()->toBeFalse()
        ->complete()->toBe($this->component)
        ->isCompleted()->toBeTrue()
        ->notComplete()->toBe($this->component)
        ->isNotCompleted()->toBeTrue();
});

it('builds the pipeline', function () {
    expect($this->component)
        ->build()->toBe($this->component)
        ->isCompleted()->toBeTrue()
        ->getName()->toBe('Pipeline 0');
});

it('builds once', function () {
    expect($this->component)
        ->build()->toBe($this->component)
        ->getName()->toBe('Pipeline 0')
        ->build()->toBe($this->component)
        ->getName()->toBe('Pipeline 0')
        ->complete(false)->toBe($this->component)
        ->build()->toBe($this->component)
        ->getName()->toBe('Pipeline 1');
});
