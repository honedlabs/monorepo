<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Fieldset;

beforeEach(function () {
    $this->file = config('form.components.fieldset');

    $this->component = Fieldset::make([]);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe($this->file)
        ->getComponent()->toBe($this->file);
});
