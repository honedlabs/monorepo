<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Password;

beforeEach(function () {
    $this->name = 'password';

    $this->file = config('honed-form.components.password');

    $this->component = Password::make($this->name);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe($this->file)
        ->getComponent()->toBe($this->file);
});
