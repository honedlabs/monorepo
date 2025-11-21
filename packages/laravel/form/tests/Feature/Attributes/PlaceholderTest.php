<?php

declare(strict_types=1);

use Honed\Form\Attributes\Placeholder;

beforeEach(function () {});

it('has attribute', function (mixed $placeholder, string $expected) {
    $attribute = new Placeholder($placeholder);

    expect($attribute)
        ->toBeInstanceOf(Placeholder::class)
        ->getValue()->toBe($expected);
})->with([
    fn () => ['Placeholder', __('Placeholder')],
]);
