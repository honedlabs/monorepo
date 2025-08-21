<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Textarea;

beforeEach(function () {
    $this->component = Textarea::make('description');
});

it('has component', function () {
    $component = config('form.components.textarea');

    expect($this->component)
        ->component()->toBe($component)
        ->getComponent()->toBe($component);
});