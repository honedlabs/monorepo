<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Select;

beforeEach(function () {
    $this->name = 'type';

    $this->file = config('form.components.select');

    $this->component = Select::make($this->name);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe($this->file)
        ->getComponent()->toBe($this->file);
});
