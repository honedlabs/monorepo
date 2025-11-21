<?php

declare(strict_types=1);

use Honed\Form\Attributes\Autofocus;

beforeEach(function () {});

it('is attribute', function () {
    $attribute = new Autofocus();

    expect($attribute)
        ->toBeInstanceOf(Autofocus::class);
});
