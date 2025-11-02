<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Textarea;

beforeEach(function () {
    $this->name = 'description';

    $this->file = config('honed-form.components.textarea');

    $this->component = Textarea::make($this->name);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe($this->file)
        ->getComponent()->toBe($this->file);
});
