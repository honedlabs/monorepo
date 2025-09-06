<?php

declare(strict_types=1);

namespace Tests\Feature\Concerns;

use Honed\Form\Form;

beforeEach(function () {
    $this->form = Form::make();
});

it('has action', function () {
    expect($this->form)
        ->getAction()->toBeNull()
        ->action('/submit')->toBe($this->form)
        ->getAction()->toBe('/submit');
});
