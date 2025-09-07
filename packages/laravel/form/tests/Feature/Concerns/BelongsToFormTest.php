<?php

declare(strict_types=1);

use Honed\Form\Components\Input;
use Honed\Form\Form;

beforeEach(function () {
    $this->component = Input::make('name');

    $this->form = Form::make();
});

it('belongs to form', function () {
    expect($this->component)
        ->getForm()->toBeNull()
        ->form($this->form)->toBe($this->component)
        ->getForm()->toBe($this->form);
});
