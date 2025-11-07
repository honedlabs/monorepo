<?php

declare(strict_types=1);

use Honed\Form\Attributes\Component;
use Honed\Form\Components\Input;

it('has attribute', function () {
    $attribute = new Component(Input::class);

    expect($attribute)
        ->toBeInstanceOf(Component::class)
        ->component->toBe(Input::class);
});
