<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Password;

beforeEach(function () {
    $this->component = Password::make('password');
});

it('has component', function () {
    $component = config('form.components.password');

    expect($this->component)
        ->component()->toBe($component)
        ->getComponent()->toBe($component);
});