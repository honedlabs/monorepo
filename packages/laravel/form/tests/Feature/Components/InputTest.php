<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('has component', function () {
    $component = config('form.components.input');

    expect($this->component)
        ->component()->toBe($component)
        ->getComponent()->toBe($component);
});