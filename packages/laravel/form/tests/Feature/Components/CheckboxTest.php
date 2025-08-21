<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Checkbox;

beforeEach(function () {
    $this->component = Checkbox::make('remember');
});

it('has component', function () {
    $component = config('form.components.checkbox');

    expect($this->component)
        ->component()->toBe($component)
        ->getComponent()->toBe($component);
});