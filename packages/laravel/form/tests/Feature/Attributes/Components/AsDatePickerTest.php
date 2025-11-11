<?php

declare(strict_types=1);

use Honed\Form\Attributes\Components\AsDatePicker;
use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\DatePicker;
use Honed\Form\Components\Input;

it('has date picker component', function () {
    $attribute = new AsDatePicker(test: true);

    expect($attribute)
        ->toBeInstanceOf(Component::class)
        ->getComponent()->toBe(DatePicker::class)
        ->getArguments()->toBe([
            'test' => true,
        ]);
});
