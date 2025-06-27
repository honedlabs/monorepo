<?php

declare(strict_types=1);

use Honed\Core\Pipes\CallsBefore;
use Workbench\App\Classes\Component;

beforeEach(function () {
    $this->pipe = new CallsBefore();

    $this->component = Component::make();
});

it('calls before', function () {
    $this->component->before(
        fn ($component) => $component->name('before')
    );

    $this->pipe->instance($this->component)->run();

    expect($this->component)
        ->getName()->toBe('before');
});
