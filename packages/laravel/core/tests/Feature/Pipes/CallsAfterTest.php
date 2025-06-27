<?php

declare(strict_types=1);

use Honed\Core\Pipes\CallsAfter;
use Workbench\App\Classes\Component;

beforeEach(function () {
    $this->pipe = new CallsAfter();

    $this->component = Component::make();
});

it('calls after', function () {
    $this->component->after(
        fn ($component) => $component->name('after')
    );

    $this->pipe->instance($this->component)->run();

    expect($this->component)
        ->getName()->toBe('after');
});
