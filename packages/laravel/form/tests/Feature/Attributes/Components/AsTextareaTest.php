<?php

declare(strict_types=1);

use Honed\Form\Attributes\Components\AsTextarea;
use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\Textarea;

it('has textarea component', function () {
    $attribute = new AsTextarea(test: true);

    expect($attribute)
        ->toBeInstanceOf(Component::class)
        ->getComponent()->toBe(Textarea::class)
        ->getArguments()->toBe([
            'test' => true,
        ]);
});
