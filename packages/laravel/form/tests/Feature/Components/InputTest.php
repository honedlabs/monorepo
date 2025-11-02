<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->name = 'name';

    $this->file = config('honed-form.components.input');

    $this->component = Input::make($this->name);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe($this->file)
        ->getComponent()->toBe($this->file);
});

it('has string empty', function () {
    expect($this->component)
        ->empty()->toBe('');
});
