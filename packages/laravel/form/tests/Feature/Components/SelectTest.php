<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Select;

beforeEach(function () {
    $this->component = Select::make('type');
});

it('has component', function () {
    $component = config('form.components.select');

    expect($this->component)
        ->component()->toBe($component)
        ->getComponent()->toBe($component);
});