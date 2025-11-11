<?php

declare(strict_types=1);

use Honed\Form\Attributes\Components\AsColorPicker;
use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\ColorPicker;

it('has color picker component', function () {
    $attribute = new AsColorPicker(test: true);

    expect($attribute)
        ->toBeInstanceOf(Component::class)
        ->getComponent()->toBe(ColorPicker::class)
        ->getArguments()->toBe([
            'test' => true,
        ]);
});
