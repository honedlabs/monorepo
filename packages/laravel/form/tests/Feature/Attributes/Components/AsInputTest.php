<?php

declare(strict_types=1);

use Honed\Form\Attributes\Components\AsInput;
use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\Input;

it('has input component', function () {
    $attribute = new AsInput(test: true);

    expect($attribute)
        ->toBeInstanceOf(Component::class)
        ->getComponent()->toBe(Input::class)
        ->getArguments()->toBe([
            'test' => true,
        ]);
});
