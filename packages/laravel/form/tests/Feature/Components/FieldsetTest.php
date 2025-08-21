<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Fieldset;

beforeEach(function () {
    $this->component = Fieldset::make([]);
});

it('has component', function () {
    $component = config('form.components.fieldset');

    expect($this->component)
        ->component()->toBe($component)
        ->getComponent()->toBe($component);
});