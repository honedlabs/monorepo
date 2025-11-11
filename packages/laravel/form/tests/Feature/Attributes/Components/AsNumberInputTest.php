<?php

declare(strict_types=1);

use Honed\Form\Attributes\Components\AsNumberInput;
use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\NumberInput;
use Honed\Form\Components\Input;

it('has number input component', function () {
    $attribute = new AsNumberInput(test: true);

    expect($attribute)
        ->toBeInstanceOf(Component::class)
        ->getComponent()->toBe(NumberInput::class)
        ->getArguments()->toBe([
            'test' => true,
        ]);
});
