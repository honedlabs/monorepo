<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Radio;

beforeEach(function () {
    $this->component = Radio::make('type');
});

it('has component', function () {
    $component = config('form.components.radio');

    expect($this->component)
        ->component()->toBe($component)
        ->getComponent()->toBe($component);
});