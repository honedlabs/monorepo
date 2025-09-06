<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Text;

beforeEach(function () {
    $this->text = 'Enter the details of the user.';

    $this->file = config('form.components.text');

    $this->component = Text::make($this->text);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe($this->file)
        ->getComponent()->toBe($this->file);
});

it('has array representation', function () {
    expect($this->component->toArray())
        ->toEqualCanonicalizing([
            'text' => $this->text,
            'component' => $this->file,
        ]);
});
