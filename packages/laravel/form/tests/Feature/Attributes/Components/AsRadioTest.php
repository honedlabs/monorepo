<?php

declare(strict_types=1);

use Honed\Form\Attributes\Components\AsRadio;
use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\Radio;

it('has radio component', function () {
    $attribute = new AsRadio(test: true);

    expect($attribute)
        ->toBeInstanceOf(Component::class)
        ->getComponent()->toBe(Radio::class)
        ->getArguments()->toBe([
            'test' => true,
        ]);
});
