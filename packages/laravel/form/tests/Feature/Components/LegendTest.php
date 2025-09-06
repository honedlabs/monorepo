<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Legend;

beforeEach(function () {
    $this->label = 'Details';

    $this->file = config('form.components.legend');

    $this->component = Legend::make($this->label);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe($this->file)
        ->getComponent()->toBe($this->file);
});

it('has array representation', function () {
    expect($this->component->toArray())
        ->toEqualCanonicalizing([
            'label' => $this->label,
            'component' => $this->file,
        ]);
});
