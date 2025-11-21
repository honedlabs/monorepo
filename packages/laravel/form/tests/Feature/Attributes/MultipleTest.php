<?php

declare(strict_types=1);

use Honed\Form\Attributes\Multiple;

beforeEach(function () {});

it('is attribute', function () {
    $attribute = new Multiple();

    expect($attribute)
        ->toBeInstanceOf(Multiple::class);
});
