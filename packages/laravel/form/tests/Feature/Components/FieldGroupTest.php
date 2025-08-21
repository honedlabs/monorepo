<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\FieldGroup;

beforeEach(function () {
    $this->component = FieldGroup::make([]);
});

it('has component', function () {
    $component = config('form.components.fieldgroup');

    expect($this->component)
        ->component()->toBe($component)
        ->getComponent()->toBe($component);
});