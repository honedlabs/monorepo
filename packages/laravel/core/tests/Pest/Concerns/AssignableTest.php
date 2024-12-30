<?php

use Workbench\App\Component;

beforeEach(function () {
    $this->component = new Component;
});

it('can mass assign properties', function () {
    $this->component->assign([
        'name' => 'Test',
        'description' => 'This is a test',
    ]);

    expect($this->component->getName())->toBe('Test');
    expect($this->component->getDescription())->toBe('This is a test');
});

it('skips properties that do not exist', function () {
    $this->component->assign([
        'name' => 'Test',
        'description' => 'This is a test',
        'unknown' => 'unknown',
    ]);

    expect($this->component->getName())->toBe('Test');
    expect($this->component->getDescription())->toBe('This is a test');
});
