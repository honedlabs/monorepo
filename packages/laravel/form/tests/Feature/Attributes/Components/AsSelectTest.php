<?php

declare(strict_types=1);

use Honed\Form\Attributes\Components\AsSelect;
use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\Select;

it('has select component', function () {
    $attribute = new AsSelect(test: true);

    expect($attribute)
        ->toBeInstanceOf(Component::class)
        ->getComponent()->toBe(Select::class)
        ->getArguments()->toBe([
            'test' => true,
        ]);
});
