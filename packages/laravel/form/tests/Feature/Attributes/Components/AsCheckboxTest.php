<?php

declare(strict_types=1);

use Honed\Form\Attributes\Components\AsCheckbox;
use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\Checkbox;

it('has checkbox component', function () {
    $attribute = new AsCheckbox(test: true);

    expect($attribute)
        ->toBeInstanceOf(Component::class)
        ->getComponent()->toBe(Checkbox::class)
        ->getArguments()->toBe([
            'test' => true,
        ]);
});
