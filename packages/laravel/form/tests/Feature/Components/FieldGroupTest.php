<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\FieldGroup;

beforeEach(function () {
    $this->file = config('honed-form.components.fieldgroup');

    $this->component = FieldGroup::make([]);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe($this->file)
        ->getComponent()->toBe($this->file);
});
