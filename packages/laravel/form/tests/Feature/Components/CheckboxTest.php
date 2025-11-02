<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Checkbox;

beforeEach(function () {
    $this->name = 'remember';

    $this->file = config('honed-form.components.checkbox');

    $this->component = Checkbox::make($this->name);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe($this->file)
        ->getComponent()->toBe($this->file);
});

it('has boolean empty', function () {
    expect($this->component)
        ->empty()->toBeFalse();
});
